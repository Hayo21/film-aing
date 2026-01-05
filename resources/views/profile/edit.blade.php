<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Profile | Film Aing</title>

    <style>
        body {
            background-color: #0F172A;
            min-height: 100vh;
        }

        /* === ANIMATIONS === */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .profile-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .profile-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .profile-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        /* === CARD STYLES === */
        .card {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: rgba(239, 68, 68, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        /* === INPUT STYLES === */
        .input-field {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            outline: none;
        }

        .input-field:disabled {
            background: rgba(15, 23, 42, 0.3);
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* === BUTTON STYLES === */
        .btn-primary {
            background: linear-gradient(135deg, #DC2626, #EF4444);
            transition: all 0.3s ease;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, #B91C1C, #DC2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-danger {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #EF4444;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: rgba(220, 38, 38, 0.2);
            border-color: rgba(220, 38, 38, 0.5);
        }

        /* === PROFILE HEADER === */
        .profile-header {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(147, 51, 234, 0.1));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);

        }

        /* === TABS === */
        .tab-button {
            position: relative;
            padding: 0.75rem 1.5rem;
            color: #94A3B8;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .tab-button:hover {
            color: #E2E8F0;
        }

        .tab-button.active {
            color: #EF4444;
            border-bottom-color: #EF4444;
        }

        /* === BADGE === */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
    </style>
</head>

<body>
    <x-navbar />

    {{-- PROFILE HEADER --}}
    <div class="profile-header py-8 pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            <div class="flex items-center gap-6">
                {{-- Avatar --}}
                <div class="relative">
                    <div
                        class="w-24 h-24 rounded-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-white text-3xl font-bold shadow-xl">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 rounded-full border-4 border-slate-900">
                    </div>
                </div>

                {{-- User Info --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2 ">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        {{ Auth::user()->email }}
                    </p>
                    <div class="mt-2">
                        <span class="badge badge-success">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Active Member
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="hidden lg:flex gap-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">127</div>
                        <div class="text-sm text-gray-400">Watched</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">45</div>
                        <div class="text-sm text-gray-400">Watchlist</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">12</div>
                        <div class="text-sm text-gray-400">Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Profile Information Card --}}
            <div class="profile-card card rounded-2xl p-8 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-red-600/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Profile Information</h2>
                        <p class="text-gray-400 text-sm">Update your account's profile information and email address.
                        </p>
                    </div>
                </div>

                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="profile-card card rounded-2xl p-8 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Update Password</h2>
                        <p class="text-gray-400 text-sm">Ensure your account is using a long, random password to stay
                            secure.</p>
                    </div>
                </div>

                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="profile-card card rounded-2xl p-8 border-red-900/30">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-red-600/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Delete Account</h2>
                        <p class="text-gray-400 text-sm">Permanently delete your account and all of its resources.</p>
                    </div>
                </div>

                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    {{-- Custom styling for form elements inside partials --}}
    <style>
        /* Override default form styles to match our theme */
        #send-verification,
        [type="submit"],
        button[type="submit"] {
            @apply btn-primary px-6 py-2.5 rounded-lg text-white font-semibold shadow-lg;
        }

        .btn-secondary,
        a.btn-secondary {
            @apply px-6 py-2.5 rounded-lg font-semibold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            @apply input-field w-full px-4 py-3 rounded-lg text-white placeholder-gray-500;
        }

        label {
            @apply block text-sm font-medium text-gray-300 mb-2;
        }

        .text-sm.text-gray-600 {
            @apply text-gray-400;
        }

        .text-sm.text-gray-800 {
            @apply text-gray-200;
        }

        /* Success message styling */
        .text-sm.text-gray-600:has(+ [x-show]) {
            @apply text-green-400;
        }

        /* Error message styling */
        .text-sm.text-red-600 {
            @apply text-red-400;
        }

        /* Link styling */
        a:not(.btn-secondary):not(.btn-primary) {
            @apply text-red-500 hover:text-red-400 transition;
        }

        /* Form sections spacing */
        form>div {
            @apply mb-6;
        }

        form>div:last-child {
            @apply mb-0;
        }

        /* Modal/Dialog styling if exists */
        .modal,
        [role="dialog"] {
            @apply bg-slate-800 border border-white/10 rounded-2xl;
        }

        /* Disabled button styling */
        button:disabled,
        [type="submit"]:disabled {
            @apply opacity-50 cursor-not-allowed;
        }

        button:disabled:hover,
        [type="submit"]:disabled:hover {
            @apply transform-none shadow-none;
        }
    </style>

</body>

</html>
