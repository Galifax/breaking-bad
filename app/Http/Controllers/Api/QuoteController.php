<?php
namespace App\Http\Controllers\Api;

use App\DataTransferObjects\CharacterFilterData;
use App\DataTransferObjects\QuoteFilterData;
use App\DataTransferObjects\QuoteRandomFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterFilterRequest;
use App\Http\Requests\QuoteFilterRequest;
use App\Http\Requests\QuoteRandomFilterRequest;
use App\Services\CharacterService;
use App\Services\QuoteService;
use App\Transformers\CharacterTransformer;
use App\Transformers\QuoteTransformer;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public QuoteService $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index(QuoteFilterRequest $request): JsonResponse
    {
        $filterData = QuoteFilterData::fromRequest($request);

        return responder()
            ->success($this->quoteService->list($filterData), new QuoteTransformer())
            ->with(['episode', 'character'])
            ->respond();
    }

    public function random(QuoteRandomFilterRequest $request): JsonResponse
    {
        $filterData = QuoteRandomFilterData::fromRequest($request);

        return responder()
            ->success($this->quoteService->random($filterData), new QuoteTransformer())
            ->with(['episode', 'character'])
            ->respond();
    }
}
