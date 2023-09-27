<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class QuoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quote' => $this->faker->text(1000),
            'episode_id' => null,
            'character_id' => null,
        ];
    }

    public function createWithEpisodeAndCharacter(
        int $countEpisodes = 2,
        int $countCharacters = 3
    ): Collection {
        $episodes = Episode::factory($countEpisodes)
            ->create();
        $characters = Character::factory($countCharacters)
            ->create();

        $ids = [];
        for($i=0; $i<$this->count; $i++) {
            $ids[] = Quote::create([
                'quote' => $this->faker->text(1000),
                'episode_id' => $episodes->random()->first()->id,
                'character_id' => $characters->random()->first()->id,
            ])->id;
        }

        return Quote::query()
            ->whereIn('id', $ids)
            ->get();
    }
}
