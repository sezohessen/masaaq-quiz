@extends('tenant.layouts.app')

@section('title', 'Start Quiz: ' . $quiz->title)

@section('content')
<div class="max-w-3xl mx-auto mt-8 px-4">

    <h1 class="text-3xl font-bold text-center mb-6">{{ $quiz->title }}</h1>
    <p class="text-gray-600 text-center mb-4">{{ $quiz->description }}</p>
    <p class="text-gray-600 text-center mb-4">Total Questions: {{ $quiz->number_of_questions }}</p>
    <p class="text-gray-600 text-center mb-4">Total Score: {{ $quiz->score }}</p>
    @if ($quiz->isInTime())
        <p class="text-gray-600 text-center mb-4">End Time: {{ $quiz->end_time->format('H:i A') }}</p>
        <p id="countdown" class="text-red-500 text-center mb-4 text-xl"></p>
    @endif

    <form id="quiz-form" method="POST" action="{{ route('quiz.finish',['quiz_attempt' => $attempt->id]) }}">
        @csrf

        @foreach($quiz->questions as $index => $question)
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 flex justify-between items-center">
                    <span>{{ $index + 1 }}. {{ $question->question }}</span>
                    <span class="text-sm text-red-500">(Score :{{ $question->score }})</span>
                </h2>
                <p class="text-gray-500 mb-2">{{ $question->description }}</p>

                @foreach($question->choices as $choice)
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice->id }}" class="form-radio text-blue-600" required>
                            <span class="ml-2">{{ $choice->title }}</span>
                        </label>
                        @if ($choice->description)
                            <p class="text-gray-400 ml-6">{{ $choice->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="text-center mt-8">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Finish Quiz</button>
        </div>
    </form>
</div>

@if ($quiz->isInTime())
<script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const endTime = new Date("{{ $quiz->end_time }}").getTime();
    $('#countdown').countdown(new Date(endTime), function(event) {
        $(this).html('Count down: '+event.strftime('%H:%M:%S'));
    }).on('finish.countdown', function() {
        document.getElementById('quiz-form').submit();
    });
});
</script>
@endif

<script>
document.getElementById('quiz-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to finish the quiz?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, finish it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, submit the form
            this.submit();
        }
    });
});
</script>
@endsection
