<?php

namespace App\Providers;

use App\Enums\ThrottleLimit;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(ThrottleLimit::APIPERMINUTE->value)->by($request->user()?->id ?: $request->ip());
        });


        RateLimiter::for('api.v1.forgot.password.limit', function (Request $request) {
            return Limit::perDay(ThrottleLimit::APIPERDAY->value)
                ->by($request->input('email') ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Çok Fazla Deneme Gerçekleştirdiniz !!!!'
                    ], Response::HTTP_TOO_MANY_REQUESTS);
                });
        });


        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
