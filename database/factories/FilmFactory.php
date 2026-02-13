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
            'title_ua' => $this->fakeUaSentence(),
            'title_en' => fake()->sentence(3),
            'description_ua' => $this->fakeUaSentence(),
            'description_en' => fake()->paragraph(),
            'poster' => 'films/posters/HaieMlbEkBPKYghBoGHVNIbFOsRzqJO6NE6tYk64.png',
            'screenshots' => [
                'films/screenshots/EFiqOYyJRVQ8MZMbiVlAGV7jIrkZUjKYxsA2OoaN.png',
                'films/screenshots/7UkiljELErnJjS1N0fnwOix4HgY62wJI8RxNqRiX.png',
            ],
            'trailer' => fake()->url(),
            'release_date' => fake()->date(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }

    private function fakeUaSentence(): string
    {
        $dictionary = [
            'Пригоди', 'Кохання', 'Місто', 'Темрява', 'Світло',
            'Мрія', 'Таємниця', 'Сонце', 'Доля', 'Вогонь',
            'Шлях', 'Свобода', 'Памʼять', 'Герой', 'Ніч'
        ];

        return collect($dictionary)
            ->random(3)
            ->implode(' ');
    }
}
