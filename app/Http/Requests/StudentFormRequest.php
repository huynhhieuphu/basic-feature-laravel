<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'student_full_name' => 'required|string|max:191',
            'student_phone' => 'required|digits:10',
            'student_course' => 'required|string|max:191',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'student_email' => 'required|email|max:191|unique:students,student_email'
            ];
        }

        if ($this->getMethod() == 'PUT') {
            $student = $this->route('student');
            $rules += [
                'student_email' => 'required|email|max:191|unique:students,student_email,' . $student->student_id . ',student_id'
            ];
        }

        return $rules;
    }

}
