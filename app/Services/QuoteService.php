<?php
namespace App\Services;

use App\Contracts\QuoteRepositoryContract;
use App\DataTransferObjects\QuoteFilterData;
use App\DataTransferObjects\QuoteRandomFilterData;
use App\Models\Character;
use App\Models\Quote;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class QuoteService
{
    private QuoteRepositoryContract $repository;

    public function __construct(QuoteRepositoryContract $quoteRepositoryContract)
    {
        $this->repository = $quoteRepositoryContract;
    }

    public function list(QuoteFilterData $filterData): Paginator
    {
        return $this->repository
            ->list($filterData);
    }

    public function getByCharacter(Character $character): Collection
    {
        return $this->repository
            ->getByCharacter($character);
    }

    public function random(QuoteRandomFilterData $filterData): ?Quote
    {
        return $this->repository
            ->random($filterData);
    }
}
