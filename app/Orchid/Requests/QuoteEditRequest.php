<?php

namespace App\Orchid\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quote.quote' => 'required|string|min:1',
            'quote.episode_id' => 'required|numeric|gt:0',
            'quote.character_id' => 'required|numeric|gt:0',
        ];
    }
}
