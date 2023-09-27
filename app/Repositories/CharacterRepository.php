<?php
namespace App\Repositories;

use App\Contracts\CharacterRepositoryContract;
use App\DataTransferObjects\CharacterFilterData;
use App\Models\Character;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class CharacterRepository implements CharacterRepositoryContract
{
    public function list(CharacterFilterData $filterData): Paginator
    {
        $name = $filterData->name;

        return Character::query()
            ->with('episodes', 'quotes')
            ->when(!empty($name), function(Builder $builder) use($name) {
                $builder->where('name', 'like', "%$name%");
            })
            ->paginate($filterData->perPage, ['*'], 'page', $filterData->page);
    }

    public function findById(int $id): ?Character
    {
        return Character::query()
            ->find($id);
    }

    public function random(): Character
    {
        return Character::query()
            ->with('episodes', 'quotes')
            ->inRandomOrder()
            ->first();
    }
}
