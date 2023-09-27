<?php

namespace App\Transformers;

use App\Models\Character;
use Flugg\Responder\Transformers\Transformer;

class CharacterTransformer extends Transformer
{
    protected $relations = [
        'episodes' => EpisodeTransformer::class,
        'quotes' => QuoteTransformer::class,
    ];

    protected $load = [];

    public function transform(Character $character): array
    {
        return [
            'id' => $character->id,
            'img' => $character->img,
            'name' => $character->name,
            'nickname' => $character->nickname,
            'birthday' => $character->birthday,
            'portrayed' => $character->portrayed,
            'occupations' => $character->occupations,
        ];
    }
}
