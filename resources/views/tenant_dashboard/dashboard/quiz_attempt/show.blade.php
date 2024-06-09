@extends('tenant_dashboard.layouts.app')
@section('title', __('Quiz result'))
@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <!-- Member Information Card -->
    <div class="bg-white shadow-md rounded p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Member Information</h2>
        <div class="flex items-center">
            <div class="ml-4">
                <div class="text-lg font-medium text-gray-900">{{ $quizAttempt->member?->name }}</div>
                <div class="text-gray-600">{{ $quizAttempt->member?->email }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded p-6">
        <x-breadCrumb.show section="Attempts" title="{{ $quizAttempt->quiz?->title }}" path="{{ route('dashboard.quiz_attempt.index') }}"/>
        <h1 class="text-3xl font-bold text-center mb-6">{{ $quizAttempt->quiz?->title }}</h1>
        <div class="text-center mb-4">
            <p class="text-gray-600 text-xl">Member Score: <span class="font-bold">{{ $quizAttempt->score }} / {{ $quizAttempt->quiz?->score }}</span></p>
            <p class="text-2xl {{ $quizAttempt->passed ? 'text-green-500' : 'text-red-500' }} font-bold">
                {{ $quizAttempt->passed ? 'Passed' : 'Failed' }}
            </p>
        </div>

        <div class="mt-6">
            @php
                $answersByQuestionId = $quizAttempt->answers->keyBy('question_id');
            @endphp
            @foreach($quizAttempt->quiz?->questions as $index => $question)
                @php
                    $userAnswer = $answersByQuestionId->get($question->id);
                @endphp
                <div class="mb-6 border-b pb-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $index + 1 }}. {{ $question->question }}</h2>
                    <p class="text-gray-500 mb-2">{{ $question->description }}</p>

                    @foreach($question->choices as $choice)
                        <div class="mb-2 flex items-center">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" class="form-radio text-blue-600" {{ $choice->id == $userAnswer?->choice_id ? 'checked' : '' }} disabled>
                            <span class="ml-2">{{ $choice->title }}</span>
                            @if($choice->is_correct)
                                <span class="ml-2 text-green-600">(Correct Answer)</span>
                            @elseif($choice->id == $userAnswer?->choice_id)
                                <span class="ml-2 text-red-500">(Member Answer)</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
