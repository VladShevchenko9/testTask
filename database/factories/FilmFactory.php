<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->boolean(),
            'title_ua' => fake()->sentence(3),
            'title_en' => fake()->sentence(3),
            'description_ua' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'poster' => fake()->imageUrl(),
            'screenshots' => json_encode([
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl(),
            ]),
            'trailer' => fake()->url(),
            'release_date' => fake()->date(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
