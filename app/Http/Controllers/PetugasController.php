<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function peminjamanIndex(Request $request): View
    {
        $query = Peminjaman::query()
            ->with(['user', 'petugas'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $peminjamans = $query->paginate(10)->withQueryString();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function pengembalianIndex(Request $request): View
    {
        $query = Pengembalian::query()
            ->with(['peminjaman.user', 'petugas'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $pengembalians = $query->paginate(10)->withQueryString();

        return view('petugas.pengembalian.index', compact('pengembalians'));
    }
}
