<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusStoreRequest extends FormRequest
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
            'name' => 'required|string|max:75|unique:statuses,name',
            'description' => 'nullable|string|max:191',
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
            'name.required' => 'Een naam is verplicht.',
            'name.unique' => 'Deze naam is al in gebruik voor een andere status.',
            'name.max' => 'De naam mag maximaal 75 karakters bevatten.',
            'description.max' => 'De beschrijving mag maximaal 191 karakters bevatten.',
        ];
    }
}
