<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanStatusRequest;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function __construct(private readonly PeminjamanService $peminjamanService)
    {
    }

    public function index(): View
    {
        $user = request()->user();
        $query = Peminjaman::query()->with(['user', 'petugas', 'details.alat'])->latest();

        if ($user->isPeminjam()) {
            $query->where('user_id', $user->id);
        }

        $peminjamans = $query->paginate(10);

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create(): View
    {
        $alats = Alat::query()->with('kategori')->where('stok_tersedia', '>', 0)->orderBy('nama_alat')->get();

        return view('peminjaman.create', compact('alats'));
    }

    public function store(StorePeminjamanRequest $request): RedirectResponse
    {
        $this->peminjamanService->create($request->validated(), $request->user());

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    public function show(Peminjaman $peminjaman): View
    {
        $this->authorizeView($peminjaman);
        $peminjaman->load(['user', 'petugas', 'details.alat', 'pengembalian.details.alat']);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function process(UpdatePeminjamanStatusRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $action = $request->validated('action');
        $catatan = $request->validated('catatan');

        if ($action === 'approve') {
            $this->peminjamanService->approve($peminjaman, $request->user(), $catatan);
            $message = 'Peminjaman berhasil disetujui.';
        } else {
            $this->peminjamanService->reject($peminjaman, $request->user(), $catatan);
            $message = 'Peminjaman berhasil ditolak.';
        }

        return redirect()->route('peminjaman.index')->with('success', $message);
    }

    private function authorizeView(Peminjaman $peminjaman): void
    {
        $user = request()->user();

        if ($user->isPeminjam() && $peminjaman->user_id !== $user->id) {
            abort(403);
        }
    }
}
