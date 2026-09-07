<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Modul\Tiket\Model\TiketMakro;
use App\Modul\Knowledgebase\Model\KBArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TiketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_active_macros(): void
    {
        $user = User::factory()->create();
        
        TiketMakro::create([
            'judul' => 'Test Macro',
            'isi' => 'Hello {{name}}',
            'aktif' => true,
            'urutan' => 1,
        ]);

        TiketMakro::create([
            'judul' => 'Inactive Macro',
            'isi' => 'Hidden',
            'aktif' => false,
            'urutan' => 2,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/tickets/macros');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'Test Macro');
    }

    public function test_authenticated_user_can_search_kb_articles(): void
    {
        $user = User::factory()->create();

        KBArticle::create([
            'judul' => 'How to sync Shopify',
            'slug' => 'how-to-sync-shopify',
            'category_id' => 1,
            'konten' => 'To sync Shopify...',
            'aktif' => true,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/tickets/kb-search?q=shopify');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.judul', 'How to sync Shopify');
    }
}
