<?php
namespace App\Repositories;

use App\Contracts\EpisodeRepositoryContract;
use App\DataTransferObjects\EpisodeFilterData;
use App\Models\Episode;
use Illuminate\Contracts\Pagination\Paginator;

class EpisodeRepository implements EpisodeRepositoryContract
{
    public function list(EpisodeFilterData $filterData): Paginator
    {
        return Episode::query()
            ->orderByDesc('air_date')
            ->paginate($filterData->perPage);
    }

    public function findById(int $id): Episode
    {
        return Episode::query()
            ->with('characters')
            ->findOrFail($id);
    }
}
