<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ getSubDomain() }} | @yield('title', __('Home'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">
    <!-- Alerts -->
    <script>
        function showAlert(type, message) {
            Swal.fire({
                icon: type,
                title: message,
                showConfirmButton: true,
                timer: 900000000
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

    @include('components.tenant.header')

    <!-- Main content area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.tenant.footer')

    @yield('js')
    @stack('scripts')
</body>
</html>
