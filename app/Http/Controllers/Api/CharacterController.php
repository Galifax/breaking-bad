<?php
namespace App\Http\Controllers\Api;

use App\DataTransferObjects\CharacterFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterFilterRequest;
use App\Services\CharacterService;
use App\Transformers\CharacterTransformer;
use Illuminate\Http\JsonResponse;

class CharacterController extends Controller
{
    public CharacterService $characterService;

    public function __construct(CharacterService $characterService)
    {
        $this->characterService = $characterService;
    }

    public function index(CharacterFilterRequest $request): JsonResponse
    {
        $filterData = CharacterFilterData::fromRequest($request);

        return responder()
            ->success($this->characterService->list($filterData), new CharacterTransformer())
            ->with(['episodes', 'quotes'])
            ->respond();
    }

    public function random(): JsonResponse
    {
        return responder()
            ->success($this->characterService->showRandom(), new CharacterTransformer())
            ->with(['episodes', 'quotes'])
            ->respond();
    }
}
