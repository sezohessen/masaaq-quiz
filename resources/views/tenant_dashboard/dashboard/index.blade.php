@extends('tenant_dashboard.layouts.app')
@section('title', __('Summary'))
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid pt-0">
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Members Count Card -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <div class="text-5xl mb-4 text-blue-500">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="text-xl font-bold">{{ __('Members') }}</h5>
                <p class="text-4xl font-semibold my-2">{{ $membersCount }}</p>
                <a href="{{ route('dashboard.member.index') }}" class="text-blue-500 hover:underline">{{ __('View Members') }}</a>
            </div>
            <!-- Quiz Count Card -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <div class="text-5xl mb-4 text-green-500">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h5 class="text-xl font-bold">{{ __('Quizzes') }}</h5>
                <p class="text-4xl font-semibold my-2">{{ $quizzesCount }}</p>
                <a href="{{ route('dashboard.quiz.index') }}" class="text-green-500 hover:underline">{{ __('View Quizzes') }}</a>
            </div>
            <!-- Attempts Count Card -->
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <div class="text-5xl mb-4 text-red-500">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="text-xl font-bold">{{ __('Attempts') }}</h5>
                <p class="text-4xl font-semibold my-2">{{ $attemptsCount }}</p>
                <a href="{{ route('dashboard.quiz_attempt.index') }}" class="text-red-500 hover:underline">{{ __('View Attempts') }}</a>
            </div>
        </div>
    </div>
</div>
<!--end::Content-->
@endsection
