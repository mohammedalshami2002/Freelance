<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'prise' => 'required|numeric|min:5',
            'description' => 'required|string',
            'categorie_id' => 'required|exists:categories,id',
            'duration_id' => 'required|exists:durations,id',
            'experience_id' => 'required|exists:experiences,id',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
        ];
    }
}
