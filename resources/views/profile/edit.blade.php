<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3">
            <div class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Pengaturan akun</div>
            <h1 class="page-title">Profil</h1>
            <p class="page-subtitle">Perbarui informasi akun, ubah password, dan kelola akses profil Anda dari satu halaman yang rapi.</p>
        </div>
    </x-slot>

    <div class="grid gap-6">
        <div class="panel p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="panel p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="panel p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
