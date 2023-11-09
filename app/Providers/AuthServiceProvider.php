<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        'App\Model' => 'App\Policies\ModelPolicy',
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::tokensExpireIn(Carbon::now()->addDays(7));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(14));



        //Passport::tokensExpireIn(now()->addDays(15));
       // Passport::refreshTokensExpireIn(now()->addDays(30));
      //  Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
