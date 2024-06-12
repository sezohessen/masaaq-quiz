@extends('tenant_dashboard.layouts.app')
@section('title', __('Quiz attempts'))
@section('content')
<!--begin::Content-->
<div class="content py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadCrumb.list_no_create section="Members" />
    <!-- Filter Form -->
    <form action="#" method="GET" class="mb-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Name, email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined at</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($members as $member)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->created_at?->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $members->withQueryString()->links() }}
    </div>
</div>
<!--end::Content-->
@endsection
