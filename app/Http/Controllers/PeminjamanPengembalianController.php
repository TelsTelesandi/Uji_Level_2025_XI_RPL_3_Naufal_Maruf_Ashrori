<?php

namespace App\Http\Controllers;

use App\Exports\PeminjamanPengembalianExport;
use App\Models\PeminjamanRuangan;
use App\Models\PengajuanPengembalian;
use App\Models\PengembalianRuangan;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanPengembalianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $type = $request->input('type', 'peminjaman'); // peminjaman or pengembalian

        if ($type === 'peminjaman') {
            $query = PeminjamanRuangan::with(['user', 'ruangan']);

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($query) use ($search) {
                        $query->where('nama_lengkap', 'like', "%{$search}%");
                    })
                        ->orWhereHas('ruangan', function ($query) use ($search) {
                            $query->where('nama_ruangan', 'like', "%{$search}%");
                        });
                });
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }

            $data = $query->orderBy($sort, $direction)->paginate(10);

            if ($request->ajax()) {
                return view('admin.peminjaman-pengembalian.peminjaman-table', compact('data', 'sort', 'direction', 'status'));
            }
        } else {
            $query = PengembalianRuangan::with(['peminjaman', 'user', 'peminjaman.ruangan']);

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($query) use ($search) {
                        $query->where('nama_lengkap', 'like', "%{$search}%");
                    })
                        ->orWhereHas('peminjaman.ruangan', function ($query) use ($search) {
                            $query->where('nama_ruangan', 'like', "%{$search}%");
                        });
                });
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }

            $data = $query->orderBy($sort, $direction)->paginate(10);

            if ($request->ajax()) {
                return view('admin.peminjaman-pengembalian.pengembalian-table', compact('data', 'sort', 'direction', 'status'));
            }
        }

        return view('admin.peminjaman-pengembalian.index', compact('data', 'search', 'sort', 'direction', 'status', 'type'));
    }

    public function create()
    {
        $users = User::all();
        $ruangan = Ruangan::all();

        return view('admin.peminjaman-pengembalian.peminjaman.create', compact('users', 'ruangan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'ruangan_id' => 'required|exists:ruangan,ruangan_id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'durasi_pinjam' => 'required|integer|min:1',
        ], [
            'user_id.required' => 'Pengguna harus dipilih.',
            'user_id.exists' => 'Pengguna tidak ditemukan dalam database.',

            'ruangan_id.required' => 'Ruangan harus dipilih.',
            'ruangan_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',

            'tanggal.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',

            'waktu_mulai.required' => 'Waktu mulai peminjaman harus diisi.',

            'durasi_pinjam.required' => 'Durasi peminjaman harus diisi.',
            'durasi_pinjam.integer' => 'Durasi peminjaman harus berupa angka.',
            'durasi_pinjam.min' => 'Durasi minimal peminjaman adalah 1 jam.',
        ]);

        // Calculate waktu_selesai based on waktu_mulai and durasi_pinjam
        $tanggal = $validated['tanggal'];
        $waktuMulai = $validated['waktu_mulai'];
        $durasiJam = $validated['durasi_pinjam']; // Assuming durasi_pinjam is in hours

        $waktuMulaiDateTime = Carbon::parse($tanggal . ' ' . $waktuMulai);
        $waktuSelesai = $waktuMulaiDateTime->copy()->addHours((int) $durasiJam);

        // Check for conflicts
        $conflictingBookings = PeminjamanRuangan::where('ruangan_id', $validated['ruangan_id'])
            ->where('status', 'disetujui')
            ->where('tanggal', $validated['tanggal'])
            ->where(function ($query) use ($waktuMulaiDateTime, $waktuSelesai) {
                $query->whereBetween('waktu_mulai', [$waktuMulaiDateTime->format('H:i:s'), $waktuSelesai->format('H:i:s')])
                    ->orWhereBetween('waktu_selesai', [$waktuMulaiDateTime->format('H:i:s'), $waktuSelesai->format('H:i:s')]);
            })
            ->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['conflict' => 'Ruangan sudah dibooking pada waktu tersebut.'])->withInput();
        }


        // Create the booking
        PeminjamanRuangan::create([
            'user_id' => $validated['user_id'],
            'ruangan_id' => $validated['ruangan_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'durasi_pinjam' => $validated['durasi_pinjam'],
            'waktu_selesai' => $waktuSelesai,
            'status' => 'disetujui',
        ]);

        return redirect()->route('peminjaman-pengembalian.index')
            ->with('success', 'Peminjaman ruangan berhasil diajukan');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
        ], [
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus salah satu dari: menunggu, disetujui, ditolak, atau selesai.',
        ]);


        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $peminjaman->status = $request->status;

        if($request->status == 'disetujui') {
            $peminjaman->ruangan->status = 'tidak_tersedia';
             $peminjaman->ruangan->save();
        }

        $peminjaman->save();

        return redirect()->route('peminjaman-pengembalian.index')
            ->with('success', 'Status peminjaman berhasil diperbarui');
    }

    public function updatePengembalianStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak,selesai',
        ], [
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus salah satu dari: menunggu, disetujui, ditolak, atau selesai.',
        ]);


        $pengembalian = PengembalianRuangan::findOrFail($id);
        $pengembalian->status = $request->status;

        if ($request->status === 'disetujui') {
            $pengembalian->tanggal_disetujui = now();

            // Update the related peminjaman status to 'selesai'
            $peminjaman = $pengembalian->peminjaman;
            $peminjaman->status = 'selesai';

            $peminjaman->ruangan->status = 'tersedia';

            $peminjaman->save();
        }

        $pengembalian->save();

        return redirect()->route('peminjaman-pengembalian.index', ['type' => 'pengembalian'])
            ->with('success', 'Status pengembalian berhasil diperbarui');
    }

     public function show(PeminjamanRuangan $peminjaman_ruangan)
    {
        $peminjaman = PeminjamanRuangan::with(['ruangan', 'user'])
            ->where('peminjaman_id', $peminjaman_ruangan->peminjaman_id)
            ->firstOrFail();

        return view('admin.peminjaman-pengembalian.peminjaman.show', [
            'peminjaman' => $peminjaman,
        ]);
    }

    public function exportData(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:all,peminjaman,pengembalian',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'export_type.required' => 'Jenis data yang ingin diekspor wajib dipilih.',
            'export_type.in' => 'Jenis data harus berupa salah satu dari: semua, peminjaman, atau pengembalian.',

            'start_date.required' => 'Tanggal awal harus diisi.',
            'start_date.date' => 'Format tanggal awal tidak valid.',

            'end_date.required' => 'Tanggal akhir harus diisi.',
            'end_date.date' => 'Format tanggal akhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
        ]);

        $export = new PeminjamanPengembalianExport(
            $request->start_date,
            $request->end_date,
            $request->export_type
        );

        return Excel::download($export, 'laporan_peminjaman_pengembalian.xlsx');
    }

     public function checkAvailability(Request $request)
    {
        $ruanganId = $request->get('ruangan_id');
        $tanggal = $request->get('tanggal');

        if (!$ruanganId || !$tanggal) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        $bookings = PeminjamanRuangan::where('ruangan_id', $ruanganId)
            ->where('tanggal', $tanggal)
            ->where('status', '!=', 'ditolak')
            ->select('waktu_mulai', 'waktu_selesai', 'status')
            ->get();

        return response()->json(['bookings' => $bookings]);
    }
    
     public function showPengembalian(PengembalianRuangan $pengembalian)
{
    // Load relasi: ruangan & user dari peminjaman
    $pengembalian->load(['peminjaman.ruangan', 'peminjaman.user']);

    return view('admin.peminjaman-pengembalian.pengembalian.show', compact('pengembalian'));
}
}
