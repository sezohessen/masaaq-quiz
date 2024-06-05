<nav aria-label="breadcrumb" class="my-2 px-2 breadcrumb-app flex justify-between items-center">
    <ol class="breadcrumb mb-0 mt-2 flex">
        <li class="breadcrumb-item text-gray-500 bg-gray-200 px-2">{{ $section }} /</li>
        <li class="breadcrumb-item active text-blue-500 bg-gray-200 px-2 ">List</li>
    </ol>
    <div class="right-actions mt-2">
        <a href="{{ $path }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">{{ __('Create') }}</a>
    </div>
</nav>
