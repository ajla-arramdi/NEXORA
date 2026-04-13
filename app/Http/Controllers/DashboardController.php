<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = request()->user();

        // Dashboard khusus petugas
        if ($user->isPetugas()) {
            $peminjamanAntrian = Peminjaman::query()
                ->with(['user'])
                ->where('status', 'diajukan')
                ->latest()
                ->get();

            $pengembalianAntrian = Pengembalian::query()
                ->with(['peminjaman.user'])
                ->where('status', 'diajukan')
                ->latest()
                ->get();

            $diprosesHariIni = Peminjaman::query()
                ->where('petugas_id', $user->id)
                ->whereDate('updated_at', Carbon::today())
                ->count()
                + Pengembalian::query()
                ->where('diterima_oleh', $user->id)
                ->whereDate('updated_at', Carbon::today())
                ->count();

            return view('petugas.dashboard', compact(
                'peminjamanAntrian',
                'pengembalianAntrian',
                'diprosesHariIni',
            ) + [
                'menungguApproval'    => $peminjamanAntrian->count(),
                'menungguPengembalian'=> $pengembalianAntrian->count(),
            ]);
        }

        // Dashboard admin & peminjam
        $peminjamanQuery = Peminjaman::query()->with(['user', 'petugas']);
        $pengembalianQuery = Pengembalian::query()->with(['peminjaman.user', 'petugas']);

        if ($user->isPeminjam()) {
            $peminjamanQuery->where('user_id', $user->id);
            $pengembalianQuery->whereHas('peminjaman', fn ($query) => $query->where('user_id', $user->id));
        }

        $stats = [
            'total_user'          => User::count(),
            'total_alat'          => Alat::count(),
            'alat_tersedia'       => Alat::sum('stok_tersedia'),
            'pengajuan_menunggu'  => (clone $peminjamanQuery)->where('status', 'diajukan')->count(),
            'total_pengembalian'  => (clone $pengembalianQuery)->count(),
        ];

        $peminjamanTerbaru   = $peminjamanQuery->latest()->take(5)->get();
        $pengembalianTerbaru = $pengembalianQuery->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'peminjamanTerbaru', 'pengembalianTerbaru'));
    }
}
