@extends('tenant_dashboard.layouts.app')
@section('title', __('Create quiz'))
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid pt-0">
    <x-breadCrumb.create section="Quizzes" path="{{ route('dashboard.quiz.index') }}" />
    <form id="quiz_form" action="{{ route('dashboard.quiz.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="title" class="required block text-sm font-medium text-gray-700">Quiz Title</label>
            <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
        </div>
        <div class="mb-4">
            <label for="description" class="required block text-sm font-medium text-gray-700">Quiz Description</label>
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
        </div>
        <div class="mb-4">
            <label for="quiz_type" class="required  text-sm font-medium text-gray-700">Quiz Type</label>
            <small class="text-gray-700">(In-time:means the quiz will be opened in exact time, Out-time: means quiz opened at any time )</small>
            <select id="quiz_type" name="quiz_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                <option value="0">Out-Time</option>
                <option value="1">In-Time</option>
            </select>
        </div>
        <div class="mb-4" id="time_container" style="display: none;">
            <label for="start_date" class="required block text-sm font-medium text-gray-700">Start Date</label>
            <input type="datetime-local" id="start_date" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <label for="end_date" class="required block text-sm font-medium text-gray-700 mt-2">End Date</label>
            <input type="datetime-local" id="end_date" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
        </div>

        <div id="questions_container" class="mb-4">
            <!-- Questions and choices will be dynamically added here -->
        </div>
        <button type="button" id="add_question" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Add Question</button>
        <button type="submit" class="w-full block mt-2 px-4 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">Create Quiz</button>
    </form>
</div>
<!--end::Content-->
@endsection
@push('scripts')
<script src="{{ global_asset('js/tenant/create_quiz.js') }}"></script>
@endpush
