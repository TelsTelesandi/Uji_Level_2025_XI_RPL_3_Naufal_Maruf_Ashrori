<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanRuangan;
use App\Models\PengembalianRuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // Get counts for stats cards
        $pengajuanPeminjaman = PeminjamanRuangan::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();

        $pengajuanPengembalian = PengembalianRuangan::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();

        $peminjaman = PeminjamanRuangan::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->whereIn('status', ['disetujui', 'selesai'])->count();

        $pengembalian = PengembalianRuangan::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->where('status', 'disetujui')->count();

        // Calculate percentage changes from last month
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentMonthStart = Carbon::now()->startOfMonth();

        // Peminjaman percentage change
        $lastMonthPeminjaman = PeminjamanRuangan::where('status', 'menunggu')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $peminjamanPercentage = $lastMonthPeminjaman > 0
            ? round((($pengajuanPeminjaman - $lastMonthPeminjaman) / $lastMonthPeminjaman) * 100)
            : 0; // Default to 5% if no data from last month

        // Pengembalian percentage change
        $lastMonthPengembalian = PengembalianRuangan::where('status', 'belum_disetujui')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $pengembalianPercentage = $lastMonthPengembalian > 0
            ? round((($pengajuanPengembalian - $lastMonthPengembalian) / $lastMonthPengembalian) * 100)
            : 0; // Default to 3% if no data from last month

        // Total peminjaman percentage change
        $lastMonthTotalPeminjaman = PeminjamanRuangan::whereIn('status', ['disetujui', 'selesai'])
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $totalPeminjamanPercentage = $lastMonthTotalPeminjaman > 0
            ? round((($peminjaman - $lastMonthTotalPeminjaman) / $lastMonthTotalPeminjaman) * 100)
            : 0; // Default to 8% if no data from last month

        // Total pengembalian percentage change
        $lastMonthTotalPengembalian = PengembalianRuangan::where('status', 'disetujui')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        $totalPengembalianPercentage = $lastMonthTotalPengembalian > 0
            ? round((($pengembalian - $lastMonthTotalPengembalian) / $lastMonthTotalPengembalian) * 100)
            : 0; // Default to 6% if no data from last month

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get chart data for 30 days
        $chartData = $this->getChartData();


        return view('admin.dashboard.index', compact(
            'pengajuanPeminjaman',
            'pengajuanPengembalian',
            'peminjaman',
            'pengembalian',
            'peminjamanPercentage',
            'pengembalianPercentage',
            'totalPeminjamanPercentage',
            'totalPengembalianPercentage',
            'recentActivities',
            'chartData'
        ));
    }

    /**
     * Get recent activities for the dashboard
     *
     * @return \Illuminate\Support\Collection
     */
    private function getRecentActivities()
    {
        // Get recent peminjaman activities
        $peminjamanActivities = PeminjamanRuangan::with(['user', 'ruangan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $activityType = '';
                $iconClass = '';

                switch ($item->status) {
                    case 'menunggu':
                        $activityType = 'Peminjaman Menunggu Persetujuan';
                        $iconClass = 'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400';
                        break;
                    case 'disetujui':
                        $activityType = 'Peminjaman Ruangan Disetujui';
                        $iconClass = 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400';
                        break;
                    case 'ditolak':
                        $activityType = 'Peminjaman Ruangan Ditolak';
                        $iconClass = 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400';
                        break;
                    case 'selesai':
                        $activityType = 'Peminjaman Ruangan Selesai';
                        $iconClass = 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400';
                        break;
                }

                return [
                    'type' => 'peminjaman',
                    'activity_type' => $activityType,
                    'user_name' => $item->user->nama_lengkap ?? 'User',
                    'ruangan_name' => $item->ruangan->nama_ruangan ?? 'Ruangan',
                    'time_ago' => $this->timeAgo($item->created_at),
                    'time' => $item->created_at->format('H:i'),
                    'icon_class' => $iconClass,
                    'created_at' => $item->created_at
                ];
            });

        // Get recent pengembalian activities
        $pengembalianActivities = PengembalianRuangan::with(['peminjaman.user', 'peminjaman.ruangan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $activityType = '';
                $iconClass = '';

                switch ($item->status) {
                    case 'belum_disetujui':
                        $activityType = 'Pengajuan Pengembalian Ruangan';
                        $iconClass = 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400';
                        break;
                    case 'disetujui':
                        $activityType = 'Pengembalian Ruangan Disetujui';
                        $iconClass = 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400';
                        break;
                }

                return [
                    'type' => 'pengembalian',
                    'activity_type' => $activityType,
                    'user_name' => $item->peminjaman->user->nama_lengkap ?? 'User',
                    'ruangan_name' => $item->peminjaman->ruangan->nama_ruangan ?? 'Ruangan',
                    'time_ago' => $this->timeAgo($item->created_at),
                    'time' => $item->created_at->format('H:i'),
                    'icon_class' => $iconClass,
                    'created_at' => $item->created_at
                ];
            });

        // Combine and sort activities
        $allActivities = $peminjamanActivities->concat($pengembalianActivities)
            ->sortByDesc('created_at')
            ->take(5)
            ->values()
            ->all();

        return $allActivities;
    }

    /**
     * Get chart data for the last 30 days
     *
     * @return array
     */
    private function getChartData()
    {
        $dates = [];
        $pengajuanPeminjamanData = [];
        $pengajuanPengembalianData = [];
        $peminjamanData = [];
        $pengembalianData = [];

        // Generate dates for the last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('d M');

            // Count peminjaman requests for this date
            $pengajuanPeminjamanData[] = PeminjamanRuangan::whereDate('created_at', $date)
                ->count();

            // Count pengembalian requests for this date
            $pengajuanPengembalianData[] = PengembalianRuangan::whereDate('created_at', $date)
                ->count();

            // Count approved peminjaman for this date
            $peminjamanData[] = PeminjamanRuangan::whereIn('status', ['disetujui', 'selesai'])
                ->whereDate('created_at', $date)
                ->count();

            // Count approved pengembalian for this date
            $pengembalianData[] = PengembalianRuangan::where('status', 'disetujui')
                ->whereDate('created_at', $date)
                ->count();
        }

        return [
            'dates' => $dates,
            'pengajuanPeminjaman' => $pengajuanPeminjamanData,
            'pengajuanPengembalian' => $pengajuanPengembalianData,
            'peminjaman' => $peminjamanData,
            'pengembalian' => $pengembalianData
        ];
    }

    /**
     * Convert timestamp to "time ago" format
     *
     * @param \Carbon\Carbon $timestamp
     * @return string
     */
    private function timeAgo($timestamp)
    {
        $now = Carbon::now();
        $diff = $timestamp->diffInHours($now);

        if ($diff < 1) {
            $minutes = $timestamp->diffInMinutes($now);
            return $minutes . ' menit yang lalu';
        } elseif ($diff < 24) {
            return $diff . ' jam yang lalu';
        } else {
            $days = $timestamp->diffInDays($now);
            return $days . ' hari yang lalu';
        }
    }
}
