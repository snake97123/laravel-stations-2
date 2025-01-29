<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startTime = CarbonImmutable::parse($this->faker->dateTimeBetween('-1 week', '+1 week'));
        $endTime = $startTime->addHours($this->faker->numberBetween(1, 4)); 

        return [
            'start_time' => $startTime,
            'end_time' => $endTime
        ];
    }
}
