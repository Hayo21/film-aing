<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    // Hash password random untuk keamanan
                    'password' => Hash::make(Str::random(64)),
                ]
            );

            Auth::login($user);

            // Log successful login untuk monitoring
            Log::info('Google login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip()
            ]);

            return redirect()->route('fordis')
                ->with('success', 'Login berhasil! Selamat datang ' . $user->name);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Google OAuth state mismatch', [
                'ip' => request()->ip(),
                'error' => $e->getMessage()
            ]);
            return redirect()->route('login')
                ->with('error', 'Sesi login Google tidak valid. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Google login failed', [
                'ip' => request()->ip(),
                'error' => $e->getMessage()
            ]);
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal! Silakan coba lagi nanti.');
        }
    }
}
