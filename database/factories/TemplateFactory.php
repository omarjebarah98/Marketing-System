<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Templates>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['email','sms']);

        return [
            'name' => $this->faker->words(3, true),
            'type' => $type,
            'subject' => $type === 'email' ? $this->faker->sentence : 'N/A',
            'content' => $type === 'email' ? $this->faker->paragraph : $this->faker->text(50),
            'variables' => ['{{customer_name}}', '{{signup_date}}'],
        ];
    }
}
