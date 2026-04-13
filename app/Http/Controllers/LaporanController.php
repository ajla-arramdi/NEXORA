<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        return view('laporan.index', $this->buildData($request));
    }

    public function print(Request $request): View
    {
        return view('laporan.print', $this->buildData($request));
    }

    private function buildData(Request $request): array
    {
        $filters = [
            'tanggal_mulai' => $request->string('tanggal_mulai')->toString(),
            'tanggal_selesai' => $request->string('tanggal_selesai')->toString(),
        ];

        $peminjamanQuery = Peminjaman::query()->with(['user', 'petugas']);
        $pengembalianQuery = Pengembalian::query()->with(['peminjaman.user', 'petugas']);

        if ($filters['tanggal_mulai']) {
            $peminjamanQuery->whereDate('tanggal_pinjam', '>=', $filters['tanggal_mulai']);
            $pengembalianQuery->whereDate('tanggal_kembali', '>=', $filters['tanggal_mulai']);
        }

        if ($filters['tanggal_selesai']) {
            $peminjamanQuery->whereDate('tanggal_pinjam', '<=', $filters['tanggal_selesai']);
            $pengembalianQuery->whereDate('tanggal_kembali', '<=', $filters['tanggal_selesai']);
        }

        return [
            'filters' => $filters,
            'peminjamans' => $peminjamanQuery->latest()->get(),
            'pengembalians' => $pengembalianQuery->latest()->get(),
            'alats' => Alat::query()->with('kategori')->orderBy('nama_alat')->get(),
        ];
    }
}
