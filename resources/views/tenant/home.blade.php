@extends('tenant.layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-4xl font-bold text-center">Welcome to {{ tenancy()->tenant?->name }}</h1>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- TODO:Card quizzes after make it --}}
           {{--  @foreach($quizzes as $quiz)
                <div class="bg-white p-4 rounded shadow-md">
                    <h2 class="text-2xl font-bold">{{ $quiz->title }}</h2>
                    <p>{{ $quiz->description }}</p>
                    <button class="bg-blue-500 text-white mt-4 px-4 py-2 rounded">Subscribe</button>
                </div>
            @endforeach --}}
        </div>
    </div>
@endsection
