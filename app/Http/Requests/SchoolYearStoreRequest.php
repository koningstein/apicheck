<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolYearStoreRequest extends FormRequest
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
            'name' => 'required|string|max:75|unique:school_years,name',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
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
            'name.unique' => 'Deze naam is al in gebruik voor een ander schooljaar.',
            'name.max' => 'De naam mag maximaal 75 karakters bevatten.',
            'startdate.required' => 'Een startdatum is verplicht.',
            'startdate.date' => 'De startdatum moet een geldige datum zijn.',
            'enddate.required' => 'Een einddatum is verplicht.',
            'enddate.date' => 'De einddatum moet een geldige datum zijn.',
            'enddate.after_or_equal' => 'De einddatum moet op of na de startdatum liggen.',
        ];
    }
}
