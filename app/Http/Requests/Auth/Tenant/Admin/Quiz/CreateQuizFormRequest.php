<?php

namespace App\Http\Requests\Auth\Tenant\Admin\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuizFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'quiz_type' => 'required|boolean',
            'start_time' => [
                'required_if:quiz_type,1',
                'nullable',
                'date_format:Y-m-d\TH:i',
            ],
            'end_time' => [
                'required_if:quiz_type,1',
                'nullable',
                'date_format:Y-m-d\TH:i',
            ],
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string',
            'question_descriptions' => 'required|array|min:1',
            'question_descriptions.*' => 'required|string',
            'question_scores' => 'required|array|min:1',
            'question_scores.*' => 'required|integer|min:0',
            'choices' => 'required|array|min:1',
            'choices.*' => 'required|array|min:2',
            'choices.*.*' => 'required|string',
            'choice_orders' => 'required|array|min:1',
            'choice_orders.*' => 'required|array|min:2',
            'choice_orders.*.*' => 'required|integer',
            'choice_descriptions' => 'required|array|min:1',
            'choice_descriptions.*' => 'required|array|min:2',
            'choice_descriptions.*.*' => 'required|string',
            'is_corrects' => 'required|array|min:1',
            'is_corrects.*' => 'required|array|min:1',
/*             'is_corrects.*.*' => 'required|in:0,1', */
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'quiz_type.required' => 'The quiz type field is required.',
            'start_time.required_if' => 'The start time is required when the quiz type is in-time.',
            'end_time.required_if' => 'The end time is required when the quiz type is in-time.',
            'end_time.after' => 'The end time must be after the start time.',
            'start_time.date_format' => 'The start time must be in the format Y-m-d H:i:s.',
            'end_time.date_format' => 'The end time must be in the format Y-m-d H:i:s.',
            'questions.required' => 'At least one question is required.',
            'questions.*.required' => 'Each question title is required.',
            'question_descriptions.required' => 'At least one question description is required.',
            'question_descriptions.*.required' => 'Each question description is required.',
            'question_scores.required' => 'At least one question score is required.',
            'question_scores.*.required' => 'Each question score is required.',
            'question_scores.*.integer' => 'Each question score must be an integer.',
            'choices.required' => 'At least two choices for each question are required.',
            'choices.*.required' => 'Each question must have at least two choices.',
            'choices.*.*.required' => 'Each choice title is required.',
            'choice_orders.required' => 'Choices order is required.',
            'choice_orders.*.required' => 'Choices order for each question is required.',
            'choice_orders.*.*.required' => 'Each choice order must be an integer.',
            'choice_descriptions.required' => 'Choice descriptions are required.',
            'choice_descriptions.*.required' => 'Each question must have at least two choice descriptions.',
            'choice_descriptions.*.*.required' => 'Each choice description is required.',
            'is_corrects.required' => 'Correct answers are required.',
            'is_corrects.*.required' => 'Each question must have at least one correct answer.',
            'is_corrects.*.*.required' => 'Each correct answer must be either 0 or 1.',
            /* 'is_corrects.*.*.in' => 'Each correct answer must be either 0 or 1.', */
        ];
    }
}
