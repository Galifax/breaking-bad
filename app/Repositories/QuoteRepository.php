<?php
namespace App\Repositories;

use App\Contracts\QuoteRepositoryContract;
use App\DataTransferObjects\QuoteFilterData;
use App\DataTransferObjects\QuoteRandomFilterData;
use App\Models\Character;
use App\Models\Quote;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class QuoteRepository implements QuoteRepositoryContract
{
    public function list(QuoteFilterData $filterData): Paginator
    {
        return Quote::query()
            ->with('episode', 'character')
            ->paginate($filterData->perPage);
    }

    public function getByCharacter(Character $character): Collection
    {
        return Quote::query()
            ->where('character_id', $character->id)
            ->get();
    }

    public function random(QuoteRandomFilterData $filterData): ?Quote
    {
        $author = $filterData->author;

        return Quote::query()
            ->with('episode', 'character')
            ->when($author, function(Builder $builder) use($author) {
                $builder->whereHas('character', function(Builder $builder) use($author) {
                    $builder->where('name', 'like',"%$author%");
                });
            })
            ->inRandomOrder()
            ->first();
    }
}
