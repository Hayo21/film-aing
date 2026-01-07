<nav class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-11/12 max-w-6xl text-gray-800">
    <div
        class="bg-white/30 backdrop-blur-xl rounded-full
            shadow-[0_8px_30px_rgba(0,0,0,0.12)]
            px-6 py-3
            border border-white/40">

        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Films Aing</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 text-gray-100">

                <a href="{{ route('home') }}"
                    class="relative font-medium transition-colors duration-200
                {{ request()->routeIs('home')
                    ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Home
                </a>

                <a href="{{ route('categories.index') }}"
                    class="relative font-medium transition-colors duration-200
{{ request()->routeIs('categories.index')
    ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
    : 'text-gray-100 hover:text-red-500
                            after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                            after:bg-red-500 after:scale-x-0 after:origin-left
                            hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Kategori
                </a>

                <a href="{{ route('fordis') }}"
                    class="relative font-medium transition-colors duration-200
                {{ request()->routeIs('fordis')
                    ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Fordis
                </a>

                <a href="{{ route('about') }}"
                    class="relative font-medium transition-colors duration-200
                {{ request()->routeIs('about')
                    ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Tentang
                </a>

            </div>

            <!-- Search, Avatar & Mobile Button -->
            <div class="flex items-center space-x-3">

                <!-- Search -->
                <div class="relative flex items-center group">
                    <input type="text" placeholder="Cari fordis..."
                        class="w-0 md:group-hover:w-44 group-focus-within:w-44
                            opacity-0 md:group-hover:opacity-100 group-focus-within:opacity-100
                            mr-2 px-3 py-1.5 text-sm text-gray-100
                            bg-white/20 backdrop-blur-md
                            border border-white/30 rounded-full
                            placeholder-gray-400
                            focus:outline-none focus:ring-2 focus:ring-red-500/50
                            transition-all duration-300" />

                    <button type="button" onclick="this.previousElementSibling.focus()"
                        class="text-gray-100 hover:text-red-500 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- User Avatar / Auth Buttons (Desktop) -->
                <div class="hidden md:block relative">
                    @auth
                        <!-- Avatar Button -->
                        <button id="user-menu-button" type="button"
                            class="flex items-center space-x-2 focus:outline-none group">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-red-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm ring-2 ring-white/50 group-hover:ring-red-500/70 transition-all duration-300">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <svg class="w-4 h-4 text-gray-100 group-hover:text-red-500 transition-colors duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-menu"
                            class="hidden absolute right-0 mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-white/40 py-2 z-50">

                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>

                            @auth
                                <a href="{{ route('bookmark.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                    </svg>
                                    <span class="hidden md:inline">Bookmark</span>
                                </a>
                            @endauth

                            <a href="{{ route('fordis') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Diskusi Saya
                            </a>

                            <div class="border-t border-gray-200 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Login & Register Buttons -->
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}"
                                class="px-4 py-1.5 text-sm font-medium text-gray-100 hover:text-red-500 transition-colors duration-200">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-1.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-full transition-colors duration-200">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button"
                    class="md:hidden text-gray-100 hover:text-red-500 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden md:hidden mt-2
            bg-white/30 backdrop-blur-xl
            rounded-2xl
            shadow-[0_8px_30px_rgba(0,0,0,0.12)]
            px-6 py-4
            border border-white/40">

        <div class="flex flex-col space-y-3 text-gray-100">

            <a href="{{ route('home') }}"
                class="relative font-medium py-2 transition-colors duration-200
                {{ request()->routeIs('home')
                    ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Home
            </a>

            <a href="{{ route('categories.index') }}"
                class="relative font-medium py-2 transition-colors duration-200
                {{ request()->routeIs('categories.index')
                    ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Kategori
            </a>

            <a href="{{ route('fordis') }}"
                class="relative font-medium py-2 transition-colors duration-200
                {{ request()->routeIs('fordis')
                    ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Fordis
            </a>

            <a href="{{ route('about') }}"
                class="relative font-medium py-2 transition-colors duration-200
                {{ request()->routeIs('about')
                    ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500'
                    : 'text-gray-100 hover:text-red-500
                                                                        after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                        after:bg-red-500 after:scale-x-0 after:origin-left
                                                                        hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Tentang
            </a>

            <!-- Mobile Auth Section -->
            <div class="pt-3 border-t border-white/20">
                @auth
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-purple-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-100">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-300">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="block py-2 text-gray-100 hover:text-red-500 transition-colors duration-200">
                        ⚙️ Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left py-2 text-red-400 hover:text-red-500 transition-colors duration-200">
                            🚪 Logout
                        </button>
                    </form>
                @else
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}"
                            class="text-center py-2 text-gray-100 hover:text-red-500 border border-white/30 rounded-full transition-colors duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="text-center py-2 text-white bg-red-600 hover:bg-red-700 rounded-full transition-colors duration-200">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>

</nav>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // User menu dropdown toggle (Desktop)
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
</script>
