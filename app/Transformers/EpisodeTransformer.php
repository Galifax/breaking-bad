<?php

namespace App\Transformers;

use App\Models\Episode;
use Flugg\Responder\Transformers\Transformer;

class EpisodeTransformer extends Transformer
{
    protected $relations = [
        'characters' => CharacterTransformer::class,
        'quotes' => QuoteTransformer::class,
    ];

    protected $load = [];

    public function transform(Episode $episode): array
    {
        return [
            'id' => $episode->id,
            'title' => $episode->title,
            'airDate' => $episode->air_date
        ];
    }
}
