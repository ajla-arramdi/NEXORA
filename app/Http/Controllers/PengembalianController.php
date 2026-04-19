<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengembalianRequest;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Services\PengembalianService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function __construct(private readonly PengembalianService $pengembalianService)
    {
    }

    public function index(): View
    {
        $user = request()->user();
        $query = Pengembalian::query()->with(['peminjaman.user', 'petugas', 'details.produk'])->latest();

        if ($user->isPeminjam()) {
            $query->whereHas('peminjaman', fn ($builder) => $builder->where('user_id', $user->id));
        }

        $pengembalians = $query->paginate(10);

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $query = Peminjaman::query()
            ->with(['details.produk', 'user'])
            ->where('status', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->latest();

        if ($user->isPeminjam()) {
            $query->where('user_id', $user->id);
        }

        $peminjamans = $query->get();
        $selectedPeminjaman = null;

        if ($request->filled('peminjaman_id')) {
            $selectedPeminjaman = $peminjamans->firstWhere('id', (int) $request->integer('peminjaman_id'));
        }

        return view('pengembalian.create', compact('peminjamans', 'selectedPeminjaman'));
    }

    public function store(StorePengembalianRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $peminjaman = Peminjaman::query()->with(['details.produk', 'user', 'pengembalian'])->findOrFail($request->input('peminjaman_id'));

        if ($request->user()->isPeminjam() && $peminjaman->user_id !== $request->user()->id) {
            abort(403);
        }

        $this->pengembalianService->create($validated, $peminjaman, $request->user());

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    public function show(Pengembalian $pengembalian): View
    {
        $user = request()->user();
        $pengembalian->load(['peminjaman.user', 'petugas', 'details.produk']);

        if ($user->isPeminjam() && $pengembalian->peminjaman->user_id !== $user->id) {
            abort(403);
        }

        return view('pengembalian.show', compact('pengembalian'));
    }

    public function terima(Request $request, Pengembalian $pengembalian): RedirectResponse
    {
        $request->validate([
            'catatan' => ['nullable', 'string'],
        ]);

        $this->pengembalianService->terima($pengembalian, $request->user(), $request->input('catatan'));

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diterima.');
    }
}
