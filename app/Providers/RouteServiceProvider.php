<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /** @var string $apiNamespace */
    protected $apiNamespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            //// default
            $tatestApiV = config('app.api.api_latest');
            Route::prefix('api')
                ->namespace('{$this->apiNamespace}/' . $tatestApiV)
                ->middleware('api', 'api_version:' . $tatestApiV)
                ->group(base_path('routes/api_' . $tatestApiV . '.php'));

            //// v1
            Route::prefix('api/v1')
                ->namespace('{$this->apiNamespace}\v1')
                ->middleware('api', 'api_version:v1')
                ->group(base_path('routes/api_v1.php'));

            //// v2
            Route::prefix('api/v2')
                ->namespace('{$this->apiNamespace}\v2')
                ->middleware('api', 'api_version:v2')
                ->group(base_path('routes/api_v2.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {


        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
