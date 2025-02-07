<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(10),
            'genre_id' => Genre::factory(),
            'image_url' => $this->faker->imageUrl(),
            'published_year' => $this->faker->numberBetween(1980, 2026),
            'is_showing' => $this->faker->boolean(),
            'description' => $this->faker->realText(100),
        ];
    }
}
