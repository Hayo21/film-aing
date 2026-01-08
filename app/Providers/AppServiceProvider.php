<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS di production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Configure Rate Limiters
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Login rate limiter - 5 attempts per minute per email+IP
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input('email');
            $key = 'login:' . strtolower($email) . '|' . $request->ip();

            return Limit::perMinute(5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan login. Silakan coba lagi setelah 1 menit.',
                    ], 429, $headers);
                });
        });

        // Register rate limiter - 5 registrations per hour per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan registrasi. Silakan coba lagi setelah 1 jam.',
                    ], 429, $headers);
                });
        });

        // Google OAuth rate limiter - 10 attempts per minute per IP
        RateLimiter::for('google-oauth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // API rate limiter (jika ada API)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
