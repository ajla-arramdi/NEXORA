<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppShell extends Component
{
    public function __construct(
        public string $title,
        public ?string $subtitle = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.app-shell');
    }
}
