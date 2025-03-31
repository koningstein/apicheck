<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CanvasSettingStoreRequest extends FormRequest
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
            'apiurl' => 'required|url|max:191',
            'apitoken' => 'required|string|max:100',
            'active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'apiurl.required' => 'De Canvas API URL is verplicht.',
            'apiurl.url' => 'De Canvas API URL moet een geldige URL zijn.',
            'apiurl.max' => 'De Canvas API URL mag maximaal 191 karakters bevatten.',
            'apitoken.required' => 'De Canvas API token is verplicht.',
            'apitoken.max' => 'De Canvas API token mag maximaal 100 karakters bevatten.',
        ];
    }
}
