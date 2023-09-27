<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CharacterSeeder extends Seeder
{
    private Collection $episodes;

    public function __construct()
    {
        $this->episodes = Episode::query()
            ->get();
    }

    public function run(): void
    {
        Character::factory(100)
            ->create()
            ->each(function (Character $character) {
                $this->attachToEpisodes($character);
                $this->addQuotes($character);
            });
    }

    private function attachToEpisodes(Character $character): void
    {
        $randomEpisodeIds = $this->episodes
            ->random(rand(5, 15))
            ->pluck('id')
            ->toArray();

        $character->episodes()
            ->attach($randomEpisodeIds);
    }

    private function addQuotes(Character $character): void
    {
        $this->episodes
            ->random(rand(3, 7))
            ->each(function(Episode $episode) use($character) {
                Quote::factory()
                    ->createOne([
                        'character_id' => $character,
                        'episode_id' => $episode
                    ]);
            });
    }
}
