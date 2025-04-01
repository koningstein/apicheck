<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentUpdateRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'crebo_id' => 'required|exists:crebos,id',
            'cohort_id' => 'required|exists:cohorts,id',
            'status_id' => 'required|exists:statuses,id',
            'enrollmentdate' => 'required|date',
            'enddate' => 'nullable|date|after_or_equal:enrollmentdate',
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
            'student_id.required' => 'Een student is verplicht.',
            'student_id.exists' => 'De geselecteerde student bestaat niet.',
            'crebo_id.required' => 'Een crebo is verplicht.',
            'crebo_id.exists' => 'De geselecteerde crebo bestaat niet.',
            'cohort_id.required' => 'Een cohort is verplicht.',
            'cohort_id.exists' => 'Het geselecteerde cohort bestaat niet.',
            'status_id.required' => 'Een status is verplicht.',
            'status_id.exists' => 'De geselecteerde status bestaat niet.',
            'enrollmentdate.required' => 'Een inschrijfdatum is verplicht.',
            'enrollmentdate.date' => 'De inschrijfdatum moet een geldige datum zijn.',
            'enddate.date' => 'De einddatum moet een geldige datum zijn.',
            'enddate.after_or_equal' => 'De einddatum moet op of na de inschrijfdatum liggen.',
        ];
    }
}
