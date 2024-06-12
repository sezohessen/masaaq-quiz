<!DOCTYPE html>
<html dir="ltr" style="direction: ltr" lang="en">
<head>
    <title>{{ __('Dashboard') }} | @yield('title', __('dashboard'))</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="#/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="kt_body" class="bg-gray-100 text-gray-900 antialiased">
    <!-- Alerts -->
    <script>
        function showAlert(type, message) {
            Swal.fire({
                icon: type
                , title: message
                , showConfirmButton: true
                , timer: 900000000
            });
        }
    </script>
    @if(session('success'))
    <script>
        showAlert('success', `{{ session('success') }}`);
    </script>
    @endif

    @if(session('error'))
    <script>
        showAlert('error', `{{ session('error') }}`);

    </script>
    @endif

    <script>
        @if($errors->any())
        showAlert('error', '<ul>@foreach ($errors->all() as $error)<li style="list-style-type: none">{{ $error }}</li>@endforeach</ul> <br>');
        @endif
    </script>

    <div class="min-h-screen flex flex-col">
        <div class="flex flex-row flex-1">
            <!-- Sidebar -->
            <div id="kt_aside" class="w-64 bg-gray-800 text-white flex-shrink-0">
                <div class="flex flex-col items-center py-4">
                    <a href="{{ route('dashboard.index') }}">
                        <img alt="Logo" src="{{ global_asset('images/logo.png') }}" class="h-16" />
                    </a>
                </div>
                <nav class="flex flex-col py-4">
                    <a href="{{ route('dashboard.index') }}" class="py-2 px-4 {{ $link == 'dashboard' && $sub_link =='' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        <i class="fa fa-tachometer-alt mr-2"></i> {{ __('Summary') }}
                    </a>
                </nav>
                <nav class="flex flex-col">
                    <a href="{{ route('dashboard.member.index') }}" class="py-2 px-4 {{ $sub_link == 'member' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        <i class="fas fa-users mr-2"></i> {{ __('Members') }}
                    </a>
                </nav>
                <nav class="flex flex-col">
                    <a href="{{ route('dashboard.quiz.index') }}" class="py-2 px-4 {{ $sub_link == 'quiz' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        <i class="fas fa-question-circle mr-2"></i> {{ __('Quizzes') }}
                    </a>
                </nav>
                <nav class="flex flex-col">
                    <a href="{{ route('dashboard.quiz_attempt.index') }}" class="py-2 px-4 {{ $sub_link == 'quiz_attempt' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        <i class="fas fa-check-circle mr-2"></i> {{ __('Quiz attempts') }}
                    </a>
                </nav>
                <nav class="flex flex-col">
                    <a href="{{ route('dashboard.csv_files.index') }}" class="py-2 px-4 {{ $sub_link == 'csv_files' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        <i class="fas fa-file mr-2"></i> {{ __('Files') }}
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <header class="bg-white shadow">
                    <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <a href="{{ URL::previous() }}" class="mr-2">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            @yield('title', 'Dashboard')
                        </h1>
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-expanded="true" aria-haspopup="true">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <div class="py-1" role="none">
                                    <div class="px-4 py-2 text-sm text-gray-700" role="menuitem">
                                        <div class="font-medium">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Logout') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content -->
                <main class="flex-1 overflow-y-auto">
                    <div class="container mx-auto px-4 py-6">
                        @yield('content')
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t py-4">
                    <div class="container mx-auto text-center text-gray-600">
                        <span>{{ date('Y') }} © {{ env('APP_NAME') }}</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    @yield('js')
    @stack('scripts')
</body>
</html>
