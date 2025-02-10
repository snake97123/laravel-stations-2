<?php

namespace Database\Seeders;

use App\Models\Genre;

use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $genres = Genre::factory(3)->create();

        $genres->each(function ($genre) {
            $movies = Movie::factory(3)->create([
                'genre_id' => $genre->id,
            ]);

        $movies->each(function ($movie) {
            Schedule::factory(3)->create([
                'movie_id' => $movie->id,
            ]);
        });
    });

    $this->call(SheetSeeder::class);
  }
}
