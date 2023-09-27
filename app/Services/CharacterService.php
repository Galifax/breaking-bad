<?php
namespace App\Services;

use App\DataTransferObjects\CharacterFilterData;
use App\Models\Character;
use App\Contracts\CharacterRepositoryContract;
use Illuminate\Contracts\Pagination\Paginator;

class CharacterService
{
    private CharacterRepositoryContract $repository;

    public function __construct(CharacterRepositoryContract $characterRepository)
    {
        $this->repository = $characterRepository;
    }

    public function list(CharacterFilterData $filterData): Paginator
    {
        return $this->repository
            ->list($filterData);
    }

    public function findById(int $id): ?Character
    {
        return $this->repository
            ->findById($id);
    }

    public function showRandom(): Character
    {
        return $this->repository
            ->random();
    }
}
