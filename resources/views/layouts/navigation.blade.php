<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('sales-pages.index') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    ✨ AI Sales Page
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-6">
                @auth
                    <span class="text-sm text-gray-600">Halo, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span></span>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition">Admin</a>
                    @endif
                    <a href="{{ route('sales-pages.index') }}" class="text-gray-600 hover:text-gray-900 transition">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 transition text-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-5 py-2 rounded-xl transition shadow-md hover:shadow-lg">
                        Daftar Gratis
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Dropdown --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            @auth
                <span class="block py-2 text-gray-600">Halo, {{ Auth::user()->name }}</span>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-600 hover:text-gray-900">Admin</a>
                @endif
                <a href="{{ route('sales-pages.index') }}" class="block py-2 text-gray-600 hover:text-gray-900">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block py-2 text-red-500 hover:text-red-700">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-gray-900">Login</a>
                <a href="{{ route('register') }}" class="block py-2 text-blue-600 hover:text-blue-700">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    }
</script>