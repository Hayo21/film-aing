<nav class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-11/12 max-w-6xl text-gray-800">
    <div
        class="bg-white/30 backdrop-blur-xl rounded-full 
            shadow-[0_8px_30px_rgba(0,0,0,0.12)] 
            px-6 py-3 
            border border-white/40 ">

        <div class="flex items-center justify-between ">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Film Aing</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 text-gray-100 ">
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

                <a href="{{ route('films') }}"
                    class="relative font-medium transition-colors duration-200
       {{ request()->routeIs('films')
           ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
           : 'text-gray-100 hover:text-red-500
                                  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                  after:bg-red-500 after:scale-x-0 after:origin-left
                                  hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Film
                </a>

                <a href="{{ route('categories') }}"
                    class="relative font-medium transition-colors duration-200
       {{ request()->routeIs('categories')
           ? 'text-blue-500 after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-500'
           : 'text-gray-100 hover:text-red-500
                                         after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                         after:bg-red-500 after:scale-x-0 after:origin-left
                                         hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                    Kategori
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

            <!-- Search & Mobile Menu Button -->
            <div class="flex items-center space-x-3">

                <!-- Expandable Glass Search -->
                <div class="relative flex items-center group">
                    <input type="text" placeholder="Cari film..."
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

    <!-- Mobile Menu - Outside rounded container -->
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


            <a href="{{ route('films') }}"
                class="relative font-medium py-2 transition-colors duration-200
         {{ request()->routeIs('films')
             ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:w-full after:h-0.5 after:bg-blue-500'
             : 'text-gray-100 hover:text-red-500
                                                                                     after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                                     after:bg-red-500 after:scale-x-0 after:origin-left
                                                                                     hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Film
            </a>

            <a href="{{ route('categories') }}"
                class="relative font-medium py-2 transition-colors duration-200
          {{ request()->routeIs('categories')
              ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:w-full after:h-0.5 after:bg-blue-500'
              : 'text-gray-100 hover:text-red-500
                                                                                   after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                                   after:bg-red-500 after:scale-x-0 after:origin-left
                                                                                   hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Kategori
            </a>

            <a href="{{ route('about') }}"
                class="relative font-medium py-2 transition-colors duration-200
         {{ request()->routeIs('about')
             ? 'text-blue-500 after:absolute after:left-0 after:bottom-0 after:w-full after:h-0.5 after:bg-blue-500'
             : 'text-gray-100 hover:text-red-500
                                                                   after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full
                                                                   after:bg-red-500 after:scale-x-0 after:origin-left
                                                                   hover:after:scale-x-100 after:transition-transform after:duration-300' }}">
                Tentang
            </a>

        </div>
    </div>
</nav>

<script>
    // Toggle Mobile Menu
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
