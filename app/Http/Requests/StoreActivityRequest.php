<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TO DO: change to false when authorization is implemented
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
            //
            // 'student_id' => 'required|integer|exists:students,id',
            // 'activity_id' => 'required|integer|exists:activities,id',
            'studentId' => 'required|integer',
            'activityId' => 'required|integer',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'student_id' => $this->studentId,
            'activity_id' => $this->activityId,
        ]);
    }
}
