<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\View\View;

class LogAktivitasController extends Controller
{
    public function index(): View
    {
        $logs = LogAktivitas::query()->with('user')->latest('created_at')->paginate(15);

        return view('log-aktivitas.index', compact('logs'));
    }
}
