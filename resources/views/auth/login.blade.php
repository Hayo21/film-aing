<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login | Film Aing</title>

    <style>
        body {
            background-color: #0F172A;
        }

        /* === ANIMATIONS === */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(400px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(239, 68, 68, 0.5);
            }
        }

        .login-container {
            animation: fadeIn 0.8s ease-out;
        }

        .login-form {
            animation: slideInLeft 0.8s ease-out 0.2s backwards;
        }

        .brand-logo {
            animation: fadeIn 1s ease-out 0.4s backwards;
        }

        #toast {
            animation: slideInRight 0.5s ease-out;
        }

        /* === INPUT STYLES === */
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #DC2626, #EF4444);
            transition: all 0.3s ease;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, #B91C1C, #DC2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* === BACKGROUND PATTERN === */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(239, 68, 68, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.08) 0%, transparent 50%);
        }

        /* === CHECKBOX CUSTOM === */
        .custom-checkbox:checked {
            background-color: #EF4444;
            border-color: #EF4444;
        }
    </style>
</head>

<body class="bg-pattern">

    <!-- Toast Notification -->
    @if (session('error') || session('success'))
        <div id="toast" class="fixed top-4 right-4 z-50 transform translate-x-0 transition-all duration-500">
            <div
                class="bg-slate-900/95 backdrop-blur-sm border {{ session('error') ? 'border-red-500' : 'border-green-500' }} rounded-lg shadow-2xl p-4 min-w-[300px] max-w-md">
                <div class="flex items-start gap-3">
                    @if (session('error'))
                        <div
                            class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    @else
                        <div
                            class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h3 class="text-white font-semibold mb-1">
                            {{ session('error') ? 'Login Gagal!' : 'Login Berhasil!' }}
                        </h3>
                        <p class="text-gray-300 text-sm">
                            {{ session('error') ?? session('success') }}
                        </p>
                    </div>

                    <button onclick="closeToast()" class="text-gray-400 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="login-container w-full max-w-6xl">
            <div
                class="grid md:grid-cols-2 gap-0 bg-slate-900/50 backdrop-blur-xl rounded-2xl overflow-hidden shadow-2xl border border-white/10">

                {{-- LEFT SIDE - BRANDING --}}
                <div
                    class="hidden md:flex flex-col justify-center items-center p-12 bg-gradient-to-br from-red-600/20 via-slate-900 to-purple-600/20 relative overflow-hidden">

                    {{-- Decorative Elements --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl"></div>

                    <div class="brand-logo relative z-10 text-center">
                        <div class="mb-8">
                            <div
                                class="w-24 h-24 mx-auto bg-gradient-to-br from-red-600 to-red-800 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                            </div>
                        </div>

                        <h1 class="text-4xl font-bold text-white mb-4">
                            Film Aing
                        </h1>
                        <p class="text-gray-400 text-lg mb-8">
                            Ngaloco Movies & Anime
                        </p>

                        <div class="space-y-4 text-left max-w-sm">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-600/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Unlimited Debat</h3>
                                    <p class="text-gray-400 text-sm">Kasih tau semua orang bahwa selere anda yang paling
                                        keren</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-600/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Multi Device</h3>
                                    <p class="text-gray-400 text-sm">Akses dari mana saja, kapan saja</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-600/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold"> Hampir Semua Movie & Anime Tersedia </h3>
                                    <p class="text-gray-400 text-sm">Menggunakan API TMDB dan Jikan</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE - LOGIN FORM --}}
                <div class="p-8 md:p-12 flex flex-col justify-center">

                    {{-- Mobile Logo --}}
                    <div class="md:hidden text-center mb-8">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-red-600 to-red-800 rounded-xl flex items-center justify-center mb-3">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Film Aing</h2>
                    </div>

                    <div class="login-form">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang!</h2>
                            <p class="text-gray-400">Masuk untuk melanjutkan streaming</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-white placeholder-gray-500"
                                        placeholder="nama@example.com" required autofocus autocomplete="username"
                                        maxlength="255">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input id="password" type="password" name="password"
                                        class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-white placeholder-gray-500"
                                        placeholder="••••••••" required autocomplete="current-password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="flex items-center cursor-pointer group">
                                    <input id="remember_me" type="checkbox"
                                        class="custom-checkbox w-4 h-4 rounded border-gray-600 bg-slate-800 text-red-600 focus:ring-red-500 focus:ring-offset-slate-900 cursor-pointer"
                                        name="remember">
                                    <span
                                        class="ml-2 text-sm text-gray-400 group-hover:text-gray-300 transition">Remember
                                        me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-sm text-red-500 hover:text-red-400 transition font-medium">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn"
                                class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-lg">
                                Sign In
                            </button>

                            <!-- Divider -->
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-slate-900 text-gray-400">Atau lanjutkan dengan</span>
                                </div>
                            </div>

                            <!-- Google Login Button -->
                            <a href="{{ route('google.login') }}"
                                class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white hover:bg-gray-100 text-gray-800 font-semibold rounded-lg transition shadow-lg">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                Lanjutkan dengan Google
                            </a>

                            <!-- Register Link -->
                            @if (Route::has('register'))
                                <p class="text-center text-gray-400 text-sm">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-red-500 hover:text-red-400 font-semibold transition">
                                        Daftar sekarang
                                    </a>
                                </p>
                            @endif
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        function closeToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Auto close after 5 seconds
        if (document.getElementById('toast')) {
            setTimeout(closeToast, 5000);
        }

        // Prevent double submission
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        loginForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing In...';

            // Re-enable after 3 seconds in case of error
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Sign In';
            }, 3000);
        });
    </script>

</body>

</html>
