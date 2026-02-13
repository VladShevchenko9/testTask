<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $roles = [
            Person::DIRECTOR => 'persons/Director.png',
            Person::WRITER => 'persons/Writer.png',
            Person::ACTOR => 'persons/Actor.png',
            Person::COMPOSER => 'persons/Composer.png',
        ];

        $films = Film::factory(20)->create();

        $peopleByRole = [];

        foreach ($roles as $role => $photo) {
            $peopleByRole[$role] = Person::factory()
                ->count(12)
                ->create(['photo' => $photo])
                ->pluck('id')
                ->all();
        }

        $countsPerFilm = [
            Person::DIRECTOR => 1,
            Person::WRITER => 2,
            Person::ACTOR => 5,
            Person::COMPOSER => 1,
        ];

        foreach ($films as $film) {
            foreach ($roles as $role => $photo) {
                $personIds = $peopleByRole[$role];
                $count = $countsPerFilm[$role];

                $picked = collect($personIds)->shuffle()->take($count);

                foreach ($picked as $personId) {
                    DB::table('film_person')->insertOrIgnore([
                        'film_id' => $film->id,
                        'person_id' => $personId,
                        'role' => $role,
                    ]);
                }
            }
        }
    }
}
