<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pengajuan;
use App\Models\User;

class OfficerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create(['role' => 'officer']);

        Pengajuan::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/pengajuans');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'user_id',
                'item_name',
                'quantity',
                'price',
                'status',
                'rejection_reason',
                'proof_of_transfer',
                'total_price',
                'created_at',
                'updated_at',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ],
            ],
        ]);
    }

    public function testShow()
    {
        $user = User::factory()->create(['role' => 'officer']);

        $pengajuan = Pengajuan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/pengajuans/{$pengajuan->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'user_id',
            'item_name',
            'quantity',
            'price',
            'status',
            'rejection_reason',
            'proof_of_transfer',
            'total_price',
            'created_at',
            'updated_at',
            'user' => [
                'id',
                'name',
                'email',
                'role',
            ],
        ]);
    }



    public function testStore()
    {
        $user = User::factory()->create(['role' => 'officer']);

        $data = [
            'user_id' => $user->id,
            'item_name' => 'Test Item',
            'quantity' => 5,
            'price' => 100,
            'status' => 'pending',
        ];

        $response = $this->actingAs($user)->postJson('/api/pengajuans', $data);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'user_id',
            'item_name',
            'quantity',
            'price',
            'status',
            'total_price',
            'created_at',
            'updated_at',
        ]);
    }


    public function testUpdate()
    {
        $user = User::factory()->create(['role' => 'officer']);

        $pengajuan = Pengajuan::factory()->create(['user_id' => $user->id]);

        $data = [
            'item_name' => 'Updated Item',
            'quantity' => 10,
            'price' => 200,
            'status' => 'approved_manager',
        ];

        $response = $this->actingAs($user)->putJson("/api/pengajuans/{$pengajuan->id}", $data);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'user_id',
            'item_name',
            'quantity',
            'price',
            'status',
            'rejection_reason',
            'proof_of_transfer',
            'total_price',
            'created_at',
            'updated_at',
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create(['role' => 'officer']);

        $pengajuan = Pengajuan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/pengajuans/{$pengajuan->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('pengajuans', ['id' => $pengajuan->id]);
    }
}