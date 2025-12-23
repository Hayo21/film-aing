<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Film Aing</title>
    <style>
        body {
            background-color: #0F172A;
        }
    </style>
</head>

<body>
    {{-- navbar --}}
    <x-navbar />
    {{-- end navbar --}}

    {{-- jumbotron --}}
    <!-- resources/views/components/film-carousel.blade.php -->
    <div class="relative w-full h-screen overflow-hidden bg-black">
        <!-- Slides Container -->
        <div id="carousel" class="relative h-full transition-transform duration-500 ease-out">

            <!-- Slide 1 -->
            <div class="carousel-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1616530940355-351fabd9524b?w=1920" alt="Film 1"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-8 md:px-16 max-w-2xl">
                        <span
                            class="inline-block px-3 py-1 bg-red-600 text-white text-sm font-semibold rounded mb-4 animate-fade-in">
                            NEW RELEASE
                        </span>
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4 animate-slide-up">
                            The Dark Knight
                        </h1>
                        <p
                            class="text-base md:text-lg lg:text-xl text-gray-300 mb-6 animate-slide-up-delay line-clamp-3 md:line-clamp-none">
                            Ketika ancaman yang dikenal sebagai Joker muncul dari masa lalunya, Batman harus menghadapi
                            ujian terbesar untuk memerangi ketidakadilan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 animate-fade-in-delay">
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Tonton Sekarang
                            </button>
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Info Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-slide absolute inset-0 w-full h-full translate-x-full">
                <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=1920" alt="Film 2"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-8 md:px-16 max-w-2xl">
                        <span
                            class="inline-block px-3 py-1 bg-yellow-500 text-black text-sm font-semibold rounded mb-4 animate-fade-in">
                            TRENDING
                        </span>
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4 animate-slide-up">
                            Inception
                        </h1>
                        <p
                            class="text-base md:text-lg lg:text-xl text-gray-300 mb-6 animate-slide-up-delay line-clamp-3 md:line-clamp-none">
                            Seorang pencuri yang mencuri rahasia perusahaan melalui teknologi berbagi mimpi diberi tugas
                            terbalik: menanamkan ide ke dalam pikiran CEO.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 animate-fade-in-delay">
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Tonton Sekarang
                            </button>
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Info Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-slide absolute inset-0 w-full h-full translate-x-full">
                <img src="https://images.unsplash.com/photo-1594908900066-3f47337549d8?w=1920" alt="Film 3"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-8 md:px-16 max-w-2xl">
                        <span
                            class="inline-block px-3 py-1 bg-purple-600 text-white text-sm font-semibold rounded mb-4 animate-fade-in">
                            POPULAR
                        </span>
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4 animate-slide-up">
                            Interstellar
                        </h1>
                        <p
                            class="text-base md:text-lg lg:text-xl text-gray-300 mb-6 animate-slide-up-delay line-clamp-3 md:line-clamp-none">
                            Tim penjelajah memanfaatkan lubang cacing yang baru ditemukan untuk melampaui batas
                            perjalanan ruang angkasa manusia dan menaklukkan jarak luas.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 animate-fade-in-delay">
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Tonton Sekarang
                            </button>
                            <button
                                class="px-6 md:px-8 py-2 md:py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-semibold rounded-lg transition-all hover:scale-105">
                                Info Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows - Hidden on mobile -->
        <button id="prevBtn"
            class="hidden md:flex absolute left-4 md:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 hover:scale-110 backdrop-blur items-center justify-center text-white transition-all duration-300 z-10 group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button id="nextBtn"
            class="hidden md:flex absolute right-4 md:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 hover:scale-110 backdrop-blur items-center justify-center text-white transition-all duration-300 z-10 group">
            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 md:bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <button class="indicator w-2 h-2 md:w-3 md:h-3 rounded-full bg-white transition-all duration-300"
                data-index="0"></button>
            <button
                class="indicator w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300"
                data-index="1"></button>
            <button
                class="indicator w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300"
                data-index="2"></button>
        </div>

        <!-- Swipe support for mobile -->
        <div id="touchArea" class="absolute inset-0 z-5 md:hidden"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.carousel-slide');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const touchArea = document.getElementById('touchArea');
            let currentSlide = 0;
            const totalSlides = slides.length;
            let autoPlayInterval;
            let touchStartX = 0;
            let touchEndX = 0;
            let isAnimating = false;

            // Animasi untuk elemen konten
            function addContentAnimation() {
                const currentSlideEl = slides[currentSlide];
                const animatedElements = currentSlideEl.querySelectorAll(
                    '.animate-fade-in, .animate-slide-up, .animate-slide-up-delay, .animate-fade-in-delay');

                animatedElements.forEach(el => {
                    el.style.animation = 'none';
                    setTimeout(() => {
                        el.style.animation = '';
                    }, 10);
                });
            }

            function updateSlides(direction = 'next') {
                if (isAnimating) return;
                isAnimating = true;

                slides.forEach((slide, index) => {
                    slide.style.transition =
                        'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.7s ease';

                    if (index === currentSlide) {
                        slide.style.transform = 'translateX(0)';
                        slide.style.opacity = '1';
                        slide.style.zIndex = '2';
                    } else {
                        // Posisikan slide berdasarkan arah navigasi
                        if (direction === 'next') {
                            // Next: slide yang sudah lewat ke kiri, yang belum ke kanan
                            if (index < currentSlide) {
                                slide.style.transform = 'translateX(-100%)';
                            } else {
                                slide.style.transform = 'translateX(100%)';
                            }
                        } else {
                            // Prev: slide yang sudah lewat ke kanan, yang belum ke kiri
                            if (index > currentSlide) {
                                slide.style.transform = 'translateX(100%)';
                            } else {
                                slide.style.transform = 'translateX(-100%)';
                            }
                        }
                        slide.style.opacity = '0';
                        slide.style.zIndex = '1';
                    }
                });

                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.remove('bg-white/40', 'hover:bg-white/60');
                        indicator.classList.add('bg-white', 'scale-125');
                    } else {
                        indicator.classList.remove('bg-white', 'scale-125');
                        indicator.classList.add('bg-white/40', 'hover:bg-white/60');
                    }
                });

                addContentAnimation();

                setTimeout(() => {
                    isAnimating = false;
                }, 700);
            }

            function nextSlide() {
                const prevSlide = currentSlide;
                currentSlide = (currentSlide + 1) % totalSlides;

                // Set posisi awal slide berikutnya
                slides[currentSlide].style.transition = 'none';
                slides[currentSlide].style.transform = 'translateX(100%)';
                slides[currentSlide].style.opacity = '0';

                setTimeout(() => {
                    updateSlides('next');
                }, 10);
            }

            function prevSlide() {
                const nextSlideIndex = currentSlide;
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;

                // Set posisi awal slide sebelumnya
                slides[currentSlide].style.transition = 'none';
                slides[currentSlide].style.transform = 'translateX(-100%)';
                slides[currentSlide].style.opacity = '0';

                setTimeout(() => {
                    updateSlides('prev');
                }, 10);
            }

            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, 5000);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            function resetAutoPlay() {
                stopAutoPlay();
                startAutoPlay();
            }

            // Event listeners untuk tombol
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetAutoPlay();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetAutoPlay();
            });

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlides();
                    resetAutoPlay();
                });
            });

            // Touch/Swipe support untuk mobile
            touchArea.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            touchArea.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        nextSlide();
                    } else {
                        // Swipe right - previous slide
                        prevSlide();
                    }
                    resetAutoPlay();
                }
            }

            // Pause autoplay saat hover (desktop)
            const carouselContainer = document.getElementById('carousel').parentElement;
            carouselContainer.addEventListener('mouseenter', stopAutoPlay);
            carouselContainer.addEventListener('mouseleave', startAutoPlay);

            // Start autoplay
            startAutoPlay();
            updateSlides();
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .animate-slide-up-delay {
            animation: slideUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }

        .animate-fade-in-delay {
            animation: fadeIn 0.8s ease-out 0.6s forwards;
            opacity: 0;
        }

        /* Line clamp utility */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    {{-- end jumbotron --}}
</body>


</html>
