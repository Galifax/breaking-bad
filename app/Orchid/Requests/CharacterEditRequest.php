<?php

namespace App\Orchid\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'character.img' => 'required|url',
            'character.name' => 'required|string|min:1|max:50',
            'character.nickname' => 'required|string|min:1|max:50',
            'character.birthday' => 'required|date',
            'character.portrayed' => 'required|string|min:1|max:50',
            'character.episodes' => 'array',
            'stringOccupations' => 'required|string',
        ];
    }
}
