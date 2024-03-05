<?php

namespace App\Providers;

use App\Enums\RoleType;
use Illuminate\Support\Facades\Gate;

use App\Enums\TokensExpireDay;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /* Passport::tokensExpireIn(now()->addDays(TokensExpireDay::ALL->value));
        Passport::refreshTokensExpireIn(now()->addDays(TokensExpireDay::REFRESH->value)); */
        Passport::personalAccessTokensExpireIn(now()->addDays(TokensExpireDay::PERSONALACCESS->value));

        Gate::before(function (User $user, $ability) {
            return $user->hasRole(RoleType::SUPER_ADMIN->value) ? true : null;
        });
    }
}
