<?php
namespace App\Http\Controllers\Api;

use App\DataTransferObjects\EpisodeFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\EpisodeFilterRequest;
use App\Services\EpisodeService;
use App\Transformers\EpisodeTransformer;
use Illuminate\Http\JsonResponse;

class EpisodeController extends Controller
{
    public EpisodeService $episodeService;

    public function __construct(EpisodeService $episodeService)
    {
        $this->episodeService = $episodeService;
    }

    public function index(EpisodeFilterRequest $request): JsonResponse
    {
        $filterData = EpisodeFilterData::fromRequest($request);

        return responder()
            ->success($this->episodeService->list($filterData), new EpisodeTransformer())
            ->respond();
    }

    public function show(int $id): JsonResponse
    {
        return responder()
            ->success($this->episodeService->show($id), new EpisodeTransformer())
            ->with(['characters', 'quotes'])
            ->respond();
    }
}
