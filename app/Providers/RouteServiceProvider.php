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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->namespace($this->namespace)
                ->prefix('api')
                // ->group(base_path('routes/api.php'));
                ->group(function ($router) {
                    require base_path('routes/api.php');
                    require base_path('routes/subroutes/admins_routes.php');
                    require base_path('routes/subroutes/distributors_routes.php');
                    require base_path('routes/subroutes/chargers_routes.php');
                    require base_path('routes/subroutes/merchants_routes.php');
                    require base_path('routes/subroutes/common_routes.php');


                });

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
