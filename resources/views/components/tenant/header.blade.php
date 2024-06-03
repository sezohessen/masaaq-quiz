<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <a href="{{ url('/') }}" class="text-white text-lg font-bold">Home</a>
            <a href="#" class="text-white text-lg ml-4">All Quizzes</a>
        </div>
        <div>
            @guest
                <a href="#" class="text-white text-lg">Login</a>
                <a href="#" class="text-white text-lg ml-4">Register</a>
            @else
                <span class="text-white text-lg">{{ Auth::user()->name }}</span>
            @endguest
        </div>
    </div>
</nav>
