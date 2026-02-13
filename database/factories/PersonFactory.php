<?php

namespace Database\Factories;

use App\Models\Person;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerUa = FakerFactory::create('uk_UA');
        $fakerEn = FakerFactory::create('en_US');

        return [
            'name_ua' => $fakerUa->name(),
            'name_en' => $fakerEn->name(),
            'photo' => 'persons/Director.png',
        ];
    }
}
