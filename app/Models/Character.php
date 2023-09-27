<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Character
 *
 * @property int $id
 * @property string $name
 * @property string $birthday
 * @property array $occupations
 * @property string $img
 * @property string $nickname
 * @property string $portrayed
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Episode> $episodes
 * @property-read int|null $episodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @method static \Database\Factories\CharacterFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Character newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Character newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Character query()
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character whereOccupations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Character wherePortrayed($value)
 * @mixin \Eloquent
 */
class Character extends Model
{
    use HasFactory, AsSource, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'occupations',
        'img',
        'nickname',
        'portrayed',
        'birthday',
    ];

    protected $casts = [
        'occupations' => 'array'
    ];

    protected array $allowedSorts = [
        'id', 'name', 'nickname', 'portrayed', 'birthday'
    ];

    protected array $allowedFilters = [
        'id', 'name', 'nickname', 'portrayed', 'birthday'
    ];

    public function episodes(): BelongsToMany
    {
        return $this->belongsToMany(Episode::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
