<?php
namespace App\DataTransferObjects;

use App\Http\Requests\QuoteRandomFilterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class QuoteRandomFilterData extends DataTransferObject
{
    public ?string $author;

    public static function fromRequest(QuoteRandomFilterRequest $request): self
    {
        return new self([
            'author' => $request->input('author'),
        ]);
    }
}
