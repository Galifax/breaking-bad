<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(100),
            'air_date' => $this->faker->dateTimeThisYear,
        ];
    }
}
