<?php
namespace App\Contracts;

use App\DataTransferObjects\QuoteFilterData;
use App\DataTransferObjects\QuoteRandomFilterData;
use App\Models\Character;
use App\Models\Quote;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface QuoteRepositoryContract
{
    public function list(QuoteFilterData $filterData): Paginator;

    public function getByCharacter(Character $character): Collection;

    public function random(QuoteRandomFilterData $filterData): ?Quote;
}
