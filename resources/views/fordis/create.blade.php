<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Buat Diskusi Baru | FORDIS</title>
    <style>
        body {
            background-color: #0F172A;
            margin-top: 8vh;
        }
    </style>
</head>

<body>
    <x-navbar />

    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-12">
        <div class="max-w-4xl mx-auto">

            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                    Buat Diskusi Baru
                </h1>
                <p class="text-gray-400">Bagikan pendapat Anda tentang film atau anime favorit</p>
            </div>

            <form action="{{ route('fordis.store') }}" method="POST"
                class="bg-slate-800/50 border border-gray-700 rounded-xl p-6 md:p-8">
                @csrf

                {{-- Search Film/Anime --}}
                <div class="mb-6">
                    <label class="block text-white font-semibold mb-3">Pilih Film atau Anime</label>

                    <div class="flex gap-2 mb-4">
                        <button type="button" id="btn-movie"
                            class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold transition hover:bg-purple-700">
                            🎬 Film
                        </button>
                        <button type="button" id="btn-anime"
                            class="flex-1 px-4 py-2 bg-slate-700 text-gray-300 rounded-lg font-semibold transition hover:bg-slate-600">
                            🎌 Anime
                        </button>
                    </div>

                    <div class="relative">
                        <input type="text" id="search-media" placeholder="Cari judul film atau anime..."
                            class="w-full bg-slate-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-red-500">

                        <div id="search-results"
                            class="hidden absolute top-full left-0 right-0 mt-2 bg-slate-700 border border-gray-600 rounded-lg max-h-96 overflow-y-auto z-10">
                            <!-- Results will be populated here -->
                        </div>
                    </div>

                    <input type="hidden" name="media_type" id="media_type" value="movie" required>
                    <input type="hidden" name="media_id" id="media_id" required>
                    <input type="hidden" name="media_title" id="media_title" required>
                    <input type="hidden" name="media_poster" id="media_poster">

                    <div id="selected-media" class="hidden mt-4 p-4 bg-slate-700/50 rounded-lg">
                        <p class="text-gray-400 text-sm mb-2">Media yang dipilih:</p>
                        <div class="flex items-center gap-3">
                            <img id="selected-poster" src="" alt=""
                                class="w-16 h-24 object-cover rounded">
                            <div>
                                <p id="selected-title" class="text-white font-semibold"></p>
                                <p id="selected-type" class="text-gray-400 text-sm"></p>
                            </div>
                        </div>
                    </div>

                    @error('media_id')
                        <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mb-6">
                    <label class="block text-white font-semibold mb-3">Kategori Diskusi</label>
                    <select name="category"
                        class="w-full bg-slate-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-500"
                        required>
                        <option value="review">Review & Rating</option>
                        <option value="recommendation">Rekomendasi</option>
                        <option value="discussion">Diskusi Umum</option>
                        <option value="theory">Teori & Analisis</option>
                        <option value="question">Pertanyaan</option>
                    </select>
                    @error('category')
                        <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Judul Diskusi --}}
                <div class="mb-6">
                    <label class="block text-white font-semibold mb-3">Judul Diskusi</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="Contoh: Review Oppenheimer - Masterpiece atau Overhyped?"
                        class="w-full bg-slate-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-red-500"
                        required>
                    @error('title')
                        <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konten Diskusi --}}
                <div class="mb-6">
                    <label class="block text-white font-semibold mb-3">Isi Diskusi</label>
                    <textarea name="content" rows="8" placeholder="Tulis pendapat, review, atau pertanyaan Anda..."
                        class="w-full bg-slate-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 resize-none"
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        Posting Diskusi
                    </button>
                    <a href="{{ route('fordis') }}"
                        class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

    <script>
        const TMDB_API_KEY = '{{ env('TMDB_API_KEY') }}'; // Mengambil dari .env
        const TMDB_IMAGE_BASE = 'https://image.tmdb.org/t/p/w500'; // Base URL untuk poster TMDB
        const btnMovie = document.getElementById('btn-movie');
        const btnAnime = document.getElementById('btn-anime');
        const searchInput = document.getElementById('search-media');
        const searchResults = document.getElementById('search-results');
        const selectedMedia = document.getElementById('selected-media');
        let currentType = 'movie';
        let searchTimeout;

        btnMovie.addEventListener('click', () => {
            currentType = 'movie';
            btnMovie.classList.remove('bg-slate-700', 'text-gray-300');
            btnMovie.classList.add('bg-purple-600', 'text-white');
            btnAnime.classList.remove('bg-blue-600', 'text-white');
            btnAnime.classList.add('bg-slate-700', 'text-gray-300');
            document.getElementById('media_type').value = 'movie';
            searchInput.value = '';
            searchResults.classList.add('hidden');
        });

        btnAnime.addEventListener('click', () => {
            currentType = 'anime';
            btnAnime.classList.remove('bg-slate-700', 'text-gray-300');
            btnAnime.classList.add('bg-blue-600', 'text-white');
            btnMovie.classList.remove('bg-purple-600', 'text-white');
            btnMovie.classList.add('bg-slate-700', 'text-gray-300');
            document.getElementById('media_type').value = 'anime';
            searchInput.value = '';
            searchResults.classList.add('hidden');
        });

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                if (currentType === 'movie') {
                    searchTMDB(query);
                } else {
                    searchJikan(query);
                }
            }, 500);
        });

        async function searchTMDB(query) {
            try {
                const response = await fetch(
                    `https://api.themoviedb.org/3/search/movie?api_key=${TMDB_API_KEY}&query=${encodeURIComponent(query)}&language=id-ID`
                );
                const data = await response.json();

                if (data.results) {
                    displayResults(data.results, 'movie');
                } else {
                    searchResults.innerHTML = '<p class="p-4 text-gray-400 text-center">Tidak ada hasil</p>';
                    searchResults.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error searching TMDB:', error);
                searchResults.innerHTML = '<p class="p-4 text-red-400 text-center">Error: ' + error.message + '</p>';
                searchResults.classList.remove('hidden');
            }
        }

        async function searchJikan(query) {
            try {
                const response = await fetch(`https://api.jikan.moe/v4/anime?q=${encodeURIComponent(query)}&limit=10`);
                const data = await response.json();

                if (data.data) {
                    displayResults(data.data, 'anime');
                } else {
                    searchResults.innerHTML = '<p class="p-4 text-gray-400 text-center">Tidak ada hasil</p>';
                    searchResults.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error searching Jikan:', error);
                searchResults.innerHTML = '<p class="p-4 text-red-400 text-center">Error: ' + error.message + '</p>';
                searchResults.classList.remove('hidden');
            }
        }

        function displayResults(results, type) {
            if (!results || results.length === 0) {
                searchResults.innerHTML = '<p class="p-4 text-gray-400 text-center">Tidak ada hasil</p>';
                searchResults.classList.remove('hidden');
                return;
            }

            const html = results.map(item => {
                let title, poster, id, year;

                if (type === 'movie') {
                    title = item.title || item.original_title;
                    // PERBAIKAN: Tambahkan base URL untuk poster TMDB
                    poster = item.poster_path ? `${TMDB_IMAGE_BASE}${item.poster_path}` : '';
                    id = item.id;
                    year = item.release_date?.substring(0, 4) || 'N/A';
                } else {
                    title = item.title;
                    poster = item.images?.jpg?.image_url || '';
                    id = item.mal_id;
                    year = item.year || 'N/A';
                }

                return `
                    <div class="flex items-center gap-3 p-3 hover:bg-slate-600 cursor-pointer border-b border-gray-600 last:border-b-0" onclick='selectMedia(${JSON.stringify(id)}, ${JSON.stringify(title)}, ${JSON.stringify(poster)}, "${type}")'>
                        ${poster ? `<img src="${poster}" alt="${title}" class="w-12 h-16 object-cover rounded" onerror="this.style.display='none'">` : '<div class="w-12 h-16 bg-slate-600 rounded flex items-center justify-center text-gray-400 text-xs">No Image</div>'}
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm">${title}</p>
                            <p class="text-gray-400 text-xs">${year}</p>
                        </div>
                    </div>
                `;
            }).join('');

            searchResults.innerHTML = html;
            searchResults.classList.remove('hidden');
        }

        window.selectMedia = function(id, title, poster, type) {
            document.getElementById('media_id').value = id;
            document.getElementById('media_title').value = title;
            document.getElementById('media_poster').value = poster;
            document.getElementById('media_type').value = type;

            if (poster) {
                document.getElementById('selected-poster').src = poster;
                document.getElementById('selected-poster').style.display = 'block';
            } else {
                document.getElementById('selected-poster').style.display = 'none';
            }

            document.getElementById('selected-title').textContent = title;
            document.getElementById('selected-type').textContent = type === 'movie' ? '🎬 Film' : '🎌 Anime';

            selectedMedia.classList.remove('hidden');
            searchResults.classList.add('hidden');
            searchInput.value = '';
        };
    </script>

</body>

</html>
