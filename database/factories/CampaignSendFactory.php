<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Campaign;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignSend>
 */
class CampaignSendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $campaign = Campaign::inRandomOrder()->first();

        $status = $this->faker->randomElement(['sent','delivered','failed']);
        $openedAt = $status === 'delivered' ? $this->faker->dateTimeBetween('-10 days', 'now') : null;
        $clickedAt = $status === 'delivered' ? $this->faker->dateTimeBetween($openedAt ?? 'now', 'now') : null;

        return [
            'campaign_id' => $campaign ? $campaign->id : null,
            'status' => $status,
            'opened_at' => $openedAt,
            'clicked_at' => $clickedAt,
            'cost' => $this->faker->randomFloat(2, 0.1, 50),
        ];
    }
}
