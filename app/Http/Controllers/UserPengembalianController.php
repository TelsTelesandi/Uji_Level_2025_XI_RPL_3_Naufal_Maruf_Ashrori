<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengembalianRuangan;
use App\Models\PeminjamanRuangan;
use Carbon\Carbon;

class UserPengembalianController extends Controller
{
    /**
     * Display a listing of user's returns
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'semua');
        $search = $request->get('search');

        $query = PengembalianRuangan::with(['peminjaman.ruangan'])
            ->whereHas('peminjaman', function ($q) use ($user) {
                $q->where('user_id', $user->user_id);
            });

        // Filter by status
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        // Search functionality
        if ($search) {
            $query->whereHas('peminjaman.ruangan', function ($q) use ($search) {
                $q->where('nama_ruangan', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $pengembalian = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('user.pengembalian.index', compact('pengembalian', 'status', 'search'));
    }

    /**
     * Show the form for creating a new return
     *
     * @param  int  $peminjamanId
     * @return \Illuminate\View\View
     */
    public function create($peminjamanId)
    {
        $user = Auth::user();

        $peminjaman = PeminjamanRuangan::with('ruangan')
            ->where('user_id', $user->user_id)
            ->where('status', 'disetujui')
            ->findOrFail($peminjamanId);

        // Check if return already exists
        $existingReturn = PengembalianRuangan::where('peminjaman_id', $peminjamanId)->first();
        if ($existingReturn) {
            return redirect()->route('user.pengembalian.index')
                ->with('error', 'Pengembalian untuk peminjaman ini sudah pernah diajukan.');
        }

        return view('user.pengembalian.create', compact('peminjaman'));
    }

    /**
     * Store a newly created return
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman_ruangan,peminjaman_id',
            'kondisi_ruangan' => 'required|in:baik,rusak_ringan,rusak_berat',
            'catatan' => 'nullable|string|max:500',
        ], [
            'peminjaman_id.required' => 'ID peminjaman harus diisi.',
            'peminjaman_id.exists' => 'ID peminjaman tidak ditemukan dalam database.',

            'kondisi_ruangan.required' => 'Kondisi ruangan harus dipilih.',
            'kondisi_ruangan.in' => 'Kondisi ruangan harus salah satu dari: baik, rusak ringan, atau rusak berat.',

            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan tidak boleh lebih dari 500 karakter.',
        ]);


        $user = Auth::user();

        // Verify the borrowing belongs to the user
        $peminjaman = PeminjamanRuangan::where('peminjaman_id', $request->peminjaman_id)
            ->where('user_id', $user->user_id)
            ->where('status', 'disetujui')
            ->first();

        // Check if return already exists
        $existingReturn = PengembalianRuangan::where('peminjaman_id', $request->peminjaman_id)->first();
        if ($existingReturn) {
            return back()->with('error', 'Pengembalian untuk peminjaman ini sudah pernah diajukan.');
        }

        PengembalianRuangan::create([
            'peminjaman_id' => $request->peminjaman_id,
            'user_id' => $user->user_id,
            'tanggal_pengajuan' => Carbon::now(),
            'kondisi_ruangan' => $request->kondisi_ruangan,
            'catatan' => $request->catatan,
            'status' => 'belum_disetujui',
        ]);

        return redirect()->route('user.pengembalian.index')
            ->with('success', 'Pengajuan pengembalian berhasil disubmit. Menunggu persetujuan admin.');
    }

    /**
     * Display the specified return
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();

        $pengembalian = PengembalianRuangan::with(['peminjaman.ruangan', 'peminjaman.user'])
            ->whereHas('peminjaman', function ($q) use ($user) {
                $q->where('user_id', $user->user_id);
            })
            ->findOrFail($id);

        return view('user.pengembalian.show', compact('pengembalian'));
    }
}
