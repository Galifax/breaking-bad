<?php

namespace App\Orchid\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'episode.title' => 'required|string|min:1|max:100',
            'episode.air_date' => 'required|date',
        ];
    }
}
