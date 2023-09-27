<?php
namespace App\Contracts;

use App\DataTransferObjects\EpisodeFilterData;
use App\Models\Episode;
use Illuminate\Contracts\Pagination\Paginator;

interface EpisodeRepositoryContract
{
    public function list(EpisodeFilterData $filterData): Paginator;

    public function findById(int $id): Episode;
}
