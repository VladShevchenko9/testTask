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
            'status' => 'required|boolean',
            'title_ua' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ua' => 'required|string',
            'description_en' => 'required|string',
            'poster' => 'required|image|max:2048',
            'screenshots.*' => 'required|image|max:2048',
            'trailer' => 'required|string',
            'release_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
