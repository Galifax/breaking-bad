<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perPage' => 'numeric|min:1|max:100',
            'page' => 'numeric|min:1',
            'name' => 'string|max:50'
        ];
    }
}
