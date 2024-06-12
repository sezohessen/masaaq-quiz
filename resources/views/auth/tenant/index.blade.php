<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <div class="bg-white shadow rounded-lg mb-5 xl:mb-8">
            <div class="py-4 px-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">{{ __('Clients') }}</h3>
                    <form action="" class="flex items-center space-x-2">
                        @csrf
                        <input type="text" value="{{ request('search') }}" placeholder="{{ __('By name, email, domain') }}" name="search" class="w-48 p-2 border border-gray-300 rounded-md" />
                        <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md">{{ __('Filter') }}</button>
                    </form>
                    <a href="{{ route('dashboard.tenants.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md flex items-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="{{ __('Add') }}">
                        <span class="mr-2">
                            <i class="fa fa-plus"></i>
                        </span>
                        {{ __('New client') }}
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50 text-gray-700 text-sm font-semibold">
                                <th class="p-3 border-b">#</th>
                                <th class="p-3 border-b">{{ __('Name') }}</th>
                                <th class="p-3 border-b">{{ __('Email') }}</th>
                                <th class="p-3 border-b">{{ __('Domain') }}</th>
                                <th class="p-3 border-b text-right">{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr class="hover:bg-gray-100">
                                <td class="p-3 border-b">{{ $client->id }}</td>
                                <td class="p-3 border-b">{{ $client->name }}</td>
                                <td class="p-3 border-b">{{ $client->email }}</td>
                                <td class="p-3 border-b">{{ $client->domain_name }}</td>
                                <td class="p-3 border-b text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="#" class="p-2 bg-yellow-500 text-white rounded-md">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clients->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
