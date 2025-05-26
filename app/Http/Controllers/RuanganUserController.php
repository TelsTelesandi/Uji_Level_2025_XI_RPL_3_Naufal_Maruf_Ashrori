<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $sort = $request->get('sort', 'nama_ruangan');
        $direction = $request->get('direction', 'asc');

        $query = Ruangan::query();

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Sorting
        $query->orderBy($sort, $direction);

        $ruangan = $query->paginate(12);

        // For AJAX requests, return only the cards partial
        if ($request->ajax()) {
            return view('user.ruangan.partials.cards', compact('ruangan', 'search', 'status', 'sort', 'direction'))->render();
        }

        return view('user.ruangan.index', compact('ruangan', 'search', 'status', 'sort', 'direction'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruangan $ruangan)
    {
        return view('user.ruangan.show', compact('ruangan'));
    }
}
