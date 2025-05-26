<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use Carbon\Carbon;

class UserPeminjamanController extends Controller
{
    /**
     * Display a listing of user's borrowings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'semua');
        $search = $request->get('search');

        $query = PeminjamanRuangan::with(['ruangan'])
            ->where('user_id', $user->user_id);

        // Filter by status
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        // Search functionality
        if ($search) {
            $query->whereHas('ruangan', function ($q) use ($search) {
                $q->where('nama_ruangan', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $peminjaman = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        // If it's an AJAX request, return only the table content
        if ($request->ajax()) {
            return view('user.peminjaman.table', compact('peminjaman'));
        }

        return view('user.peminjaman.index', compact('peminjaman', 'status', 'search'));
    }

    /**
     * Show the form for creating a new borrowing
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $ruangan = Ruangan::where('status', 'tersedia')->get();

        return view('user.peminjaman.create', compact('ruangan'));
    }

    /**
     * Store a newly created borrowing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangan,ruangan_id',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'durasi_pinjam' => 'required|integer|min:1|max:24',
            'keperluan' => 'required|string|max:500',
        ], [
            'ruangan_id.required' => 'Ruangan harus dipilih.',
            'ruangan_id.exists' => 'Ruangan yang dipilih tidak tersedia.',

            'tanggal.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal peminjaman minimal hari ini atau setelahnya.',

            'waktu_mulai.required' => 'Waktu mulai harus diisi.',

            'durasi_pinjam.required' => 'Durasi peminjaman harus diisi.',
            'durasi_pinjam.integer' => 'Durasi peminjaman harus berupa angka.',
            'durasi_pinjam.min' => 'Durasi minimal peminjaman adalah 1 jam.',
            'durasi_pinjam.max' => 'Durasi maksimal peminjaman adalah 24 jam.',

            'keperluan.required' => 'Keperluan peminjaman harus diisi.',
            'keperluan.string' => 'Keperluan harus berupa teks.',
            'keperluan.max' => 'Keperluan tidak boleh lebih dari 500 karakter.',
        ]);

        $user = Auth::user();

        $tanggal = Carbon::parse($request->tanggal);

        // Calculate end time
        $waktuMulai = Carbon::parse($tanggal->format('Y-m-d') . ' ' . $request->waktu_mulai);
        $waktuSelesai = $waktuMulai->copy()->addHours((int) $request->durasi_pinjam);

        $jamBatas = Carbon::parse($tanggal->format('Y-m-d') . ' 22:00:00');

        if ($waktuSelesai > $jamBatas) {
            return back()->withErrors([
                'conflict' => 'Durasi peminjaman tidak boleh lebih dari jam 10 malam ' . $tanggal->locale('id')->translatedFormat("d F Y")
            ])->withInput();
        }

        if ( Carbon::parse($tanggal->format('Y-m-d') . ' ' . $waktuMulai->format('H:i:s')) >= $jamBatas) {
            return back()->withErrors([
                'conflict' => 'Waktu peminjaman tidak boleh lebih dari jam 10 malam ' . $tanggal->locale('id')->translatedFormat("d F Y")
            ])->withInput();
        }

        // Check for conflicts
        $conflict = PeminjamanRuangan::where('ruangan_id', $request->ruangan_id)
            ->where('tanggal', $request->tanggal)
            ->where('status', '!=', 'ditolak')
            ->where(function ($query) use ($request, $waktuSelesai) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $waktuSelesai->format('H:i')])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $waktuSelesai->format('H:i')])
                    ->orWhere(function ($q) use ($request, $waktuSelesai) {
                        $q->where('waktu_mulai', '<=', $request->waktu_mulai)
                            ->where('waktu_selesai', '>=', $waktuSelesai->format('H:i'));
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['waktu_mulai' => 'Ruangan sudah dipesan pada waktu tersebut.'])->withInput();
        }

        PeminjamanRuangan::create([
            'user_id' => $user->user_id,
            'ruangan_id' => $request->ruangan_id,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => Carbon::parse($tanggal->format('Y-m-d') . ' ' . $waktuSelesai->format('H:i:s')),
            'durasi_pinjam' => $request->durasi_pinjam,
            'keperluan' => $request->keperluan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disubmit. Menunggu persetujuan admin.');
    }

    /**
     * Display the specified borrowing
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();

        $peminjaman = PeminjamanRuangan::with(['ruangan', 'user'])
            ->where('user_id', $user->user_id)
            ->findOrFail($id);

        return view('user.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Cancel a pending borrowing request
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $user = Auth::user();

        $peminjaman = PeminjamanRuangan::where('user_id', $user->user_id)
            ->where('status', 'menunggu')
            ->findOrFail($id);

        $peminjaman->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    /**
     * Check room availability
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
}
