<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <a href="{{ url('/') }}" class="text-white text-lg font-bold">Home</a>
            @auth
            <a href="{{ route('quiz_attempt.index') }}" class="text-white text-lg ml-4">My quizzes</a>
            @endauth
        </div>
        <div class="relative">
            @guest
                <a href="{{ route('login') }}" class="text-white text-lg">Login</a>
                <a href="{{ route('register') }}" class="text-white text-lg ml-4">Register</a>
            @else
                <div class="relative inline-block text-left">
                    <button id="dropdownUserButton" data-dropdown-toggle="dropdownUser" class="text-white text-lg focus:outline-none">
                        {{ Auth::user()->name }}
                        <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownUser" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                               Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>

