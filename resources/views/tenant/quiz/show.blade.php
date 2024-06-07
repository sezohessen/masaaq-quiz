@extends('tenant.layouts.app')
@section('title', $quiz->title)
@section('content')
<div class="max-w-3xl mx-auto mt-8 px-4 ">
    <div class="bg-white shadow-md rounded-lg px-6 py-8 pb-8">

        <!-- Quiz Title -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $quiz->title }}</h1>

        <!-- Quiz Description -->
        <p class="text-lg text-gray-600 mb-6">{{ $quiz->description }}</p>

        <!-- Number of Questions and Score -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <span class="text-sm text-gray-500">Number of Questions:</span>
                <span class="text-lg font-bold text-blue-500">{{ $quiz->number_of_questions }}</span>
            </div>
            <div>
                <span class="text-sm text-gray-500">Score:</span>
                <span class="text-lg font-bold text-blue-500">{{ $quiz->score }}</span>
            </div>
        </div>

        <!-- Quiz Type -->
        <div class="mb-6">
            <span class="text-sm text-gray-500">Quiz Type:</span>
            <span class="text-lg font-bold text-blue-500">{{ $quiz->type }}</span>
        </div>

        <!-- Start and End Time (if applicable) -->
        @if ($quiz->type === '1')
        <div class="mb-6">
            <span class="text-sm text-gray-500">Start Time:</span>
            <span class="text-lg font-bold text-blue-500">{{ $quiz->start_time?->format('Y-m-d H:i') }}</span>
        </div>
        <div class="mb-6">
            <span class="text-sm text-gray-500">End Time:</span>
            <span class="text-lg font-bold text-blue-500">{{ $quiz->end_time?->format('Y-m-d H:i') }}</span>
        </div>
        @endif

        <!-- Begin Quiz Button (with conditional availability) -->
        @if ($quiz->isAvailableToStartNow())
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            <a href="{{ route('quiz.subscribe',['quiz' => $quiz->id]) }}">Begin quiz</a>
        </button>
        @else
        @if ($quiz->isEnded())
        <span class="text-blue-500">Finished</span>
        @else
        <a href="{{ route('quiz.subscribe',['quiz' => $quiz->id]) }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">
            Subscribe
        </a>
        <span class="text-blue-500 block">Start at: {{ $quiz->start_time?->format('Y-m-d h:i A') }}</span>
        @endif
        @endif
    </div>
</div>
@endsection
