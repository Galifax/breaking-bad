<?php
namespace App\Services;

use App\DataTransferObjects\EpisodeFilterData;
use App\Models\Episode;
use App\Contracts\EpisodeRepositoryContract;
use Illuminate\Contracts\Pagination\Paginator;

class EpisodeService
{
    private EpisodeRepositoryContract $repository;

    public function __construct(EpisodeRepositoryContract $episodeRepository)
    {
        $this->repository = $episodeRepository;
    }

    public function list(EpisodeFilterData $filterData): Paginator
    {
        return $this->repository
            ->list($filterData);
    }

    public function show(int $id): Episode
    {
        return $this->repository
            ->findById($id);
    }
}
