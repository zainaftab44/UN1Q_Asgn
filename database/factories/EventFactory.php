<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $occurrences = 10 + fake()->randomDigitNotZero();
        return [
            'title' => fake()->sentence(),
            'summary' => fake()->sentences(asText: true),
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
            'interval' => fake()->randomElement(['daily', 'monthly']),
            // 'occurrence' => $occurrences,
            'until_datetime' => now()->addDays(10 + fake()->randomDigitNotZero())->toDateTimeString(),
        ];
    }
}

