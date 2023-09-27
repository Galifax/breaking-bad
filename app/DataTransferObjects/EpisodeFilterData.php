<?php
namespace App\DataTransferObjects;

use App\Http\Requests\EpisodeFilterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class EpisodeFilterData extends DataTransferObject
{
    public int $perPage;

    public int $page;

    public static function fromRequest(EpisodeFilterRequest $request): self
    {
        return new self([
            'perPage' => (int)$request->input('perPage', 10),
            'page' => (int)$request->input('page', 1),
        ]);
    }
}
