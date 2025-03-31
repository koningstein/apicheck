<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'eduarteid' => 'required|string|max:10|unique:students,eduarteid,' . $this->route('student')->id,
            'canvasid' => 'nullable|string|max:50|unique:students,canvasid,' . $this->route('student')->id,
            'isactive' => 'sometimes|boolean',
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
            'eduarteid.required' => 'Een Eduarte ID is verplicht.',
            'eduarteid.unique' => 'Dit Eduarte ID is al in gebruik voor een andere student.',
            'eduarteid.max' => 'Het Eduarte ID mag maximaal 10 karakters bevatten.',
            'canvasid.max' => 'Het Canvas ID mag maximaal 50 karakters bevatten.',
            'canvasid.unique' => 'Dit Canvas ID is al in gebruik voor een andere student.',
        ];
    }
}
