<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Template;
use App\Models\Campaign;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaigns>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $template = Template::inRandomOrder()->first();

        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = (clone $startDate)->modify('+'.rand(1,10).' days');

        return [
            'template_id' => $template ? $template->id : null,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'target_audience' => $this->faker->word,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['draft','active','paused','completed']),
        ];
    }
}
