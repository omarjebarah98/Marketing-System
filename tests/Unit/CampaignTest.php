<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Campaign;
use App\Models\Template;
use App\Models\CampaignSend;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_campaign()
    {
        $template = Template::factory()->create();

        $campaign = Campaign::factory()->create([
            'template_id' => $template->id,
        ]);

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'title' => $campaign->title
        ]);
    }

    /** @test */
    public function campaign_belongs_to_template()
    {
        $template = Template::factory()->create();
        $campaign = Campaign::factory()->create([
            'template_id' => $template->id,
        ]);

        $this->assertInstanceOf(Template::class, $campaign->template);
    }

    /** @test */
    public function campaign_has_many_sends()
    {
        $campaign = Campaign::factory()->create();

        CampaignSend::factory()->count(3)->create([
            'campaign_id' => $campaign->id
        ]);

        $this->assertEquals(3, $campaign->sends()->count());
    }
}
