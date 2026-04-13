<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="page-title">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="page-subtitle">{{ $subtitle }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="flex flex-wrap items-center gap-3">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    </x-slot>

    {{ $slot }}
</x-app-layout>
