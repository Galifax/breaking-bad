<?php

namespace App\Transformers;

use App\Models\Quote;
use Flugg\Responder\Transformers\Transformer;

class QuoteTransformer extends Transformer
{
    protected $relations = [
        'episode' => EpisodeTransformer::class,
        'character' => CharacterTransformer::class,
    ];

    protected $load = [];

    public function transform(Quote $quote): array
    {
        return [
            'id' => $quote->id,
            'quote' => $quote->quote,
        ];
    }
}
