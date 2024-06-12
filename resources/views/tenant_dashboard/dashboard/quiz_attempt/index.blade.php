@extends('tenant_dashboard.layouts.app')
@section('title', __('Quiz attempts'))
@section('content')
<!--begin::Content-->
<div class="content py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <x-breadCrumb.list_no_create section="Attempts" />
        <form action="#">
            @csrf
            <input type="hidden" name="download" value="csv">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Download CSV <i class="fa fa-download"></i>
            </button>
        </form>
    </div>
    <!-- Filter Form -->
    <form action="#" method="GET" class="mb-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Quiz, Member" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="quiz_type" class="block text-sm font-medium text-gray-700">Quiz Type</label>
                <select name="quiz_type" id="quiz_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="1" {{ request('quiz_type') == '1' ? 'selected' : '' }}>In Time</option>
                    <option value="0" {{ request('quiz_type') == '0' ? 'selected' : '' }}>Out Time</option>
                </select>
            </div>
            <div>
                <label for="result" class="block text-sm font-medium text-gray-700">Result</label>
                <select name="result" id="result" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select Type</option>
                    <option value="1" {{ request('result') == '1' ? 'selected' : '' }}>Passed</option>
                    <option value="0" {{ request('result') == '0' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
                    Filter <i class="fa fa-filter"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Quizzes Table -->
    <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Finished At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">View</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($quizAttempts as $attempt)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->member?->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->quiz?->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->score}}/{{ $attempt->quiz?->score }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        @if ($attempt->passed)
                        <span class="text-green-600">Passed</span>
                        @else
                        <span class="text-red-600">Failed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->end_time?->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->quiz?->quiz_type == 1 ? 'In-Time' : 'Out-Time' }}</td>
                    <td>
                        <a href="{{ route('dashboard.quiz_attempt.show',['quiz_attempt' => $attempt->id]) }}" class="text-blue-500">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $quizAttempts->withQueryString()->links() }}
    </div>
</div>
<!--end::Content-->
@endsection
