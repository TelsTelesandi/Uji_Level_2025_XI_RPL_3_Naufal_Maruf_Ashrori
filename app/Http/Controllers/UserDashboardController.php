<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get user's active borrowings
        $peminjamanAktif = PeminjamanRuangan::where('user_id', $user->user_id)
            ->where('status', 'disetujui')
            ->where('tanggal', '>=', now()->toDateString())
            ->count();

        // Get pending approvals
        $menungguPersetujuan = PeminjamanRuangan::where('user_id', $user->user_id)
            ->where('status', 'menunggu')
            ->count();

        // Get borrowing history
        $riwayatPeminjaman = PeminjamanRuangan::where('user_id', $user->user_id)
            ->whereIn('status', ['selesai'])
            ->count();

        // Get upcoming reservations
        $upcomingReservations = PeminjamanRuangan::with('ruangan')
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['disetujui', 'menunggu'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->limit(5)
            ->get();

        // Get available rooms for today
        $availableRooms = Ruangan::where('status', 'tersedia')
            ->limit(6)
            ->get();

        return view('user.dashboard', compact(
            'peminjamanAktif',
            'menungguPersetujuan',
            'riwayatPeminjaman',
            'upcomingReservations',
            'availableRooms'
        ));
    }
}
