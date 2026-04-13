<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $petugas = User::factory()->create(['role' => User::ROLE_PETUGAS]);
        $peminjam = User::factory()->create(['role' => User::ROLE_PEMINJAM]);

        $this->actingAs($admin)->get('/users')->assertOk();
        $this->actingAs($petugas)->get('/users')->assertForbidden();
        $this->actingAs($peminjam)->get('/users')->assertForbidden();
    }

    public function test_petugas_can_access_master_data_but_peminjam_cannot(): void
    {
        $petugas = User::factory()->create(['role' => User::ROLE_PETUGAS]);
        $peminjam = User::factory()->create(['role' => User::ROLE_PEMINJAM]);

        $this->actingAs($petugas)->get('/alat')->assertOk();
        $this->actingAs($peminjam)->get('/alat')->assertForbidden();
    }
}
