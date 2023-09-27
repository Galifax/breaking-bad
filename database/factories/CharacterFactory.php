<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'birthday' => $this->faker->dateTimeBetween('-70 years', '-15 years'),
            'occupations' => $this->faker->sentences(5),
            'img' => $this->faker->imageUrl,
            'nickname' => $this->faker->word,
            'portrayed' => $this->faker->name
        ];
    }
}
