@extends('tenant_dashboard.layouts.app')
@section('title', __('Quiz attempts'))
@section('content')
<!--begin::Content-->
<div class="content py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadCrumb.list_no_create section="Attempts"/>

    <!-- Quizzes Table -->
    <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Finished At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">View</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($quizAttempts as $attempt)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->member?->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->quiz?->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->score }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        @if ($attempt->passed)
                        <span class="text-green-600">Passed</span>
                        @else
                        <span class="text-red-600">Failed</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attempt->end_time?->format('Y-m-d') }}</td>
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
