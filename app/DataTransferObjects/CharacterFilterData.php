<?php
namespace App\DataTransferObjects;

use App\Http\Requests\CharacterFilterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CharacterFilterData extends DataTransferObject
{
    public ?int $perPage = 10;

    public ?int $page = 1;

    public ?string $name;

    public static function fromRequest(CharacterFilterRequest $request): self
    {
        return new self([
            'perPage' => (int)$request->input('perPage', 10),
            'page' => (int)$request->input('page', 1),
            'name' => $request->input('name'),
        ]);
    }
}
