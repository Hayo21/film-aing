<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register | Film Aing</title>

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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .register-container {
            animation: fadeIn 0.8s ease-out;
        }

        .register-form {
            animation: slideInRight 0.8s ease-out 0.2s backwards;
        }

        .brand-logo {
            animation: fadeIn 1s ease-out 0.4s backwards;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
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

        .btn-primary:hover {
            background: linear-gradient(135deg, #B91C1C, #DC2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* === BACKGROUND PATTERN === */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 80% 20%, rgba(239, 68, 68, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(147, 51, 234, 0.08) 0%, transparent 50%);
        }

        /* === PASSWORD STRENGTH INDICATOR === */
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* === PROGRESS STEPS === */
        .step-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .step-indicator.active {
            background: linear-gradient(135deg, #DC2626, #EF4444);
            border-color: #EF4444;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>

<body class="bg-pattern">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="register-container w-full max-w-6xl">
            <div
                class="grid md:grid-cols-2 gap-0 bg-slate-900/50 backdrop-blur-xl rounded-2xl overflow-hidden shadow-2xl border border-white/10">

                {{-- LEFT SIDE - REGISTRATION FORM --}}
                <div class="p-8 md:p-12 flex flex-col justify-center order-2 md:order-1">

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

                    <div class="register-form">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold text-white mb-2">Buat Akun Baru</h2>
                            <p class="text-gray-400">Daftar dan mulai streaming sekarang!</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-5">
                            @csrf

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                                        class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-white placeholder-gray-500"
                                        placeholder="John Doe" required autofocus autocomplete="name">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-sm" />
                            </div>

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
                                        placeholder="nama@example.com" required autocomplete="username">
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
                                        placeholder="Minimal 8 karakter" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />

                                <!-- Password Strength Indicator -->
                                <div class="mt-2 flex gap-2">
                                    <div class="flex-1 h-1 rounded-full bg-slate-700"></div>
                                    <div class="flex-1 h-1 rounded-full bg-slate-700"></div>
                                    <div class="flex-1 h-1 rounded-full bg-slate-700"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Gunakan minimal 8 karakter dengan kombinasi huruf
                                    dan angka</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                                    Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-white placeholder-gray-500"
                                        placeholder="Ulangi password" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-sm" />
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="flex items-start">
                                <input id="terms" type="checkbox"
                                    class="w-4 h-4 mt-1 rounded border-gray-600 bg-slate-800 text-red-600 focus:ring-red-500 focus:ring-offset-slate-900"
                                    required>
                                <label for="terms" class="ml-2 text-sm text-gray-400">
                                    Saya setuju dengan
                                    <a href="#" class="text-red-500 hover:text-red-400 font-medium">Terms of
                                        Service</a>
                                    dan
                                    <a href="#" class="text-red-500 hover:text-red-400 font-medium">Privacy
                                        Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-lg">
                                Daftar Sekarang
                            </button>

                            <!-- Login Link -->
                            <p class="text-center text-gray-400 text-sm">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                    class="text-red-500 hover:text-red-400 font-semibold transition">
                                    Masuk di sini
                                </a>
                            </p>
                        </form>
                    </div>

                </div>

                {{-- RIGHT SIDE - BRANDING --}}
                <div
                    class="hidden md:flex flex-col justify-center items-center p-12 bg-gradient-to-br from-purple-600/20 via-slate-900 to-red-600/20 relative overflow-hidden order-1 md:order-2">

                    {{-- Decorative Elements --}}
                    <div class="absolute top-0 left-0 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-64 h-64 bg-red-600/20 rounded-full blur-3xl"></div>

                    <div class="brand-logo relative z-10 text-center">

                        {{-- Floating Movie Icon --}}
                        <div class="mb-8 float-animation">
                            <div
                                class="w-32 h-32 mx-auto bg-gradient-to-br from-red-600 to-red-800 rounded-3xl flex items-center justify-center shadow-2xl">
                                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                            </div>
                        </div>

                        <h1 class="text-4xl font-bold text-white mb-4">
                            Bergabung dengan Film Aing
                        </h1>
                        <p class="text-gray-400 text-lg mb-12">
                            Banyak pengguna yang telah berdebat dan bertarung untuk menentukan selera siapa yang terbaik
                            disini!
                        </p>

                        {{-- Registration Steps --}}
                        <div class="space-y-4 text-left max-w-sm">
                            <h3 class="text-white font-semibold text-lg mb-4">Langkah Mudah Bergelut:</h3>

                            <div class="flex items-center gap-4">
                                <div class="step-indicator active">
                                    <span class="text-white font-bold">1</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Daftar Gratis</p>
                                    <p class="text-gray-400 text-sm">kek login biasa ae</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="step-indicator">
                                    <span class="text-gray-400 font-bold">2</span>
                                </div>
                                <div>
                                    <p class="text-gray-300 font-medium">Langsung Ke Halaman FORDIS</p>
                                    <p class="text-gray-500 text-sm">Cek info perdebatan terbaru</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="step-indicator">
                                    <span class="text-gray-400 font-bold">3</span>
                                </div>
                                <div>
                                    <p class="text-gray-300 font-medium">Mulai Berdebat</p>
                                    <p class="text-gray-500 text-sm">Akses film & anime banyak jadi bisa banyak bacot
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
