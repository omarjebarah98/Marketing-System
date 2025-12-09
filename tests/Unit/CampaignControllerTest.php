<?php

namespace Tests\Unit;


use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Campaign;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_campaign()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $template = Template::factory()->create();

        $response = $this->postJson('/api/campaigns', [
            'template_id' => $template->id,
            'title' => 'Test Campaign',
            'description' => 'My test campaign',
            'target_audience' => 'all',
            'start_date' => '2025-12-10',
            'end_date' => '2025-12-20',
            'status' => 'paused',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
             'data' => ['id', 'title', 'description', 'target_audience', 'start_date', 'end_date', 'status', 'statistics']
        ]);
    }

    /** @test */
    public function it_fetches_a_campaign()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $campaign = Campaign::factory()->create();

        $response = $this->getJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $campaign->id]]);
    }

    /** @test */
    public function it_updates_a_campaign()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $template = Template::factory()->create();

        $campaign = Campaign::factory()->create();

        $response = $this->putJson("/api/campaigns/{$campaign->id}", [
            'template_id' => $template->id,
            'title' => 'Updated',
            'description' => 'My test campaign',
            'target_audience' => 'all',
            'start_date' => '2025-12-10',
            'end_date' => '2025-12-20',
            'status' => 'paused',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('campaigns', ['title' => 'Updated']);
    }

    /** @test */
    public function it_deletes_a_campaign()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $campaign = Campaign::factory()->create();

        $response = $this->deleteJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('campaigns', ['id' => $campaign->id]);
    }
}
