<?php
namespace App\Http\Controllers\Api;

use App\DataTransferObjects\CharacterFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CharacterFilterRequest;
use App\Services\CharacterService;
use App\Services\StatService;
use App\Transformers\CharacterTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public StatService $statService;

    public function __construct(StatService $statService)
    {
        $this->statService = $statService;
    }

    public function stats(): JsonResponse
    {
        return responder()
            ->success(['count' => $this->statService->totalRequest()])
            ->respond();
    }

    public function myStats(Request $request): JsonResponse
    {
        return responder()
            ->success(['count' => $this->statService->requestsByUser($request->user())])
            ->respond();
    }
}
