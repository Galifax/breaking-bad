<?php
namespace App\Contracts;

use App\DataTransferObjects\CharacterFilterData;
use App\Models\Character;
use Illuminate\Contracts\Pagination\Paginator;

interface CharacterRepositoryContract
{
    public function list(CharacterFilterData $filterData): Paginator;

    public function findById(int $id): ?Character;

    public function random(): Character;
}
