@extends('tenant.layouts.app')

@section('title', 'Quiz Result for: ' . $quizAttempt->quiz?->title)

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <div class="bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold text-center mb-6">{{ $quizAttempt->quiz?->title }}</h1>
        <div class="text-center mb-4">
            <p class="text-gray-600 text-xl">Your Score: <span class="font-bold">{{ $quizAttempt->score }} / {{ $quizAttempt->quiz?->score }}</span></p>
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
                                <span class="ml-2 text-red-500">(Your Answer)</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('quiz.show', ['id' => $quizAttempt->quiz?->id, 'quiz' => $quizAttempt->quiz?->slug]) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Back to Quiz</a>
        </div>
    </div>
</div>
@endsection
