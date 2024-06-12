@extends('tenant_dashboard.layouts.app')
@section('title', __('CSV files'))
@section('content')
<!--begin::Content-->
<div class="content py-6 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadCrumb.list_no_create section="Files" />
    <!-- Quizzes Table -->
    <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($files as $file)
                <tr>
                    @php
                        try {
                            $fileName = explode('exports/',$file)[1];
                        } catch (\Exepetion $th) {
                            $fileName = $file;
                        }
                    @endphp
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fileName }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <form action="#">
                            @csrf
                            <input type="hidden" name="download" value="{{ $fileName }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Download CSV <i class="fa fa-download"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--end::Content-->
@endsection
