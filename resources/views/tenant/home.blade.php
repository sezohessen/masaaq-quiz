@extends('tenant.layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-4xl font-bold text-center">Welcome to {{ getSubDomain() }}</h1>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($quizzes as $quiz)
                <div class="bg-gradient-to-br from-gray-800 to-gray-600 text-white rounded-lg shadow-md overflow-hidden relative">
                    <div class="bg-white bg-opacity-50 p-2 absolute top-0 right-0 rounded-tr-lg rounded-bl-lg text-xs">
                        {{ $quiz->type }}
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-bold border-b border-gray-300 pb-2">{{ $quiz->title }}</h2>
                        <p class="text-white line-clamp-2">{{ $quiz->description }}</p>
                        <div class="flex justify-between mt-4">
                            <span class="text-sm text-gray-300">Questions: {{ $quiz->number_of_questions }}</span>
                            <span class="text-sm text-gray-300">Score: {{ $quiz->score }}</span>
                        </div>
                        <div class="mt-4">
                            @if ($quiz->quiz_type == 1)
                                @if ($quiz->isAvailableToStartNow())
                                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Start Quiz</a>
                                @else
                                    @if ($quiz->isEnded())
                                        <span class="text-blue-500">Finished</span>
                                    @else
                                        <a href="{{ route('quiz.show', ['id' => $quiz->id, 'quiz' => $quiz->slug]) }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">
                                            Subscribe
                                        </a>
                                        <span class="text-blue-500 block">Start at: {{ $quiz->start_time?->format('Y-m-d h:i A') }}</span>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('quiz.show', ['id' => $quiz->id, 'quiz' => $quiz->slug]) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                    Start Quiz
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
