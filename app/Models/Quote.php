<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Quote
 *
 * @property int $id
 * @property string $quote
 * @property int $episode_id
 * @property int $character_id
 * @property-read \App\Models\Character $character
 * @property-read \App\Models\Episode $episode
 * @method static \Illuminate\Database\Eloquent\Builder|Quote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereEpisodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quote whereQuote($value)
 * @mixin \Eloquent
 */
class Quote extends Model
{
    use HasFactory, AsSource, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'quote',
        'episode_id',
        'character_id'
    ];

    protected array $allowedSorts = [
        'id', 'quote', 'episode_id', 'character_id',
    ];

    protected array $allowedFilters = [
        'id', 'quote', 'episode_id', 'character_id',
    ];


    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function getShortQuote(): string
    {
        return mb_strimwidth($this->quote, 0, 100, "...");
    }
}
