<?php

namespace App\Http\Requests\Tenant\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class FinishQuizRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'answers.*' => 'required|exists:choices,id',
        ];
    }

    public function messages()
    {
        return [
            'answers.*.required' => 'Please select an answer for all questions.',
            'answers.*.exists' => 'Invalid choice selected for one or more questions.',
        ];
    }
}
