<?php
namespace App\DataTransferObjects;

use App\Http\Requests\QuoteFilterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class QuoteFilterData extends DataTransferObject
{
    public int $perPage;

    public int $page;

    public ?string $name;

    public static function fromRequest(QuoteFilterRequest $request): self
    {
        return new self([
            'perPage' => (int)$request->input('perPage', 10),
            'page' => (int)$request->input('page', 1),
        ]);
    }
}
