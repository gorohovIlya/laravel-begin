<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'phone' => '+7'.fake()->numerify('##########'),
            'agreed' => fake()->boolean(90),
        ];
    }

    public function agreed(): static
    {
        return $this->state(fn (array $attributes) => [
            'agreed' => true,
        ]);
    }
}
