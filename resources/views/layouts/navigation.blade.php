<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('sales-pages.index') }}" class="text-xl font-bold text-gray-900">
                    ✨ AI Sales Page
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-gray-600">Halo, {{ Auth::user()->name }}</span>
                    <a href="{{ route('sales-pages.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 text-sm transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>