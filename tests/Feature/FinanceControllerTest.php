<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pengajuan;

class FinanceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create(['role' => 'finance']);
        $pengajuan = Pengajuan::factory()->create(['status' => 'approved_manager']);

        $response = $this->actingAs($user)->getJson('/api/finance/pengajuans');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function testApprovePengajuan()
    {
        $user = User::factory()->create(['role' => 'manager']);
        $pengajuan = Pengajuan::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($user)->postJson("/api/manager/pengajuans/{$pengajuan->id}/approve");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Pengajuan approved successfully']);

        $this->assertDatabaseHas('pengajuans', ['id' => $pengajuan->id, 'status' => 'approved_manager']);
        $this->assertNotNull(Pengajuan::find($pengajuan->id)->proof_of_transfer);
    }
    public function testRejectPengajuan()
    {
        $user = User::factory()->create(['role' => 'finance']);
        $pengajuan = Pengajuan::factory()->create(['status' => 'approved_manager']);

        $response = $this->actingAs($user)->postJson("/api/finance/pengajuans/{$pengajuan->id}/reject", ['reason' => 'Test reason']);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Pengajuan rejected successfully']);

        $this->assertDatabaseHas('pengajuans', ['id' => $pengajuan->id, 'status' => 'rejected', 'rejection_reason' => 'Test reason']);
    }
}