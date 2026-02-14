<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'actors' => ['nullable', 'array'],
            'actors.' => ['integer', 'exists:people,id', 'distinct'],
            'composers' => ['nullable', 'array'],
            'composers.' => ['integer', 'exists:people,id', 'distinct'],
            'description_en' => 'required|string',
            'description_ua' => 'required|string',
            'directors' => ['nullable', 'array'],
            'directors.' => ['integer', 'exists:people,id', 'distinct'],
            'end_date' => 'required|date|after:start_date',
            'poster' => 'nullable|image|max:2048',
            'release_date' => 'required|date',
            'screenshots.*' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'status' => 'required|boolean',
            'title_en' => 'required|string|max:255',
            'title_ua' => 'required|string|max:255',
            'trailer' => 'required|string',
            'writers' => ['nullable', 'array'],
            'writers.' => ['integer', 'exists:people,id', 'distinct'],
        ];
    }
}
