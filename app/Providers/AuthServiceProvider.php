<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view dashboard', function (User $user) {
            return $user->hasPermissionTo('view dashboard');
        });

        Gate::define('view statistics', function (User $user) {
            return $user->hasPermissionTo('view statistics');
        });

        Gate::define('manage roles', function (User $user) {
            return $user->hasPermissionTo('manage roles');
        });

        Gate::define('manage permissions', function (User $user) {
            return $user->hasPermissionTo('manage permissions');
        });

        Gate::define('manage associations', function (User $user) {
            return $user->hasPermissionTo('manage associations');
        });

        Gate::define('view events', function (User $user) {
            return $user->hasPermissionTo('view events');
        });

        Gate::define('create events', function (User $user) {
            return $user->hasPermissionTo('create events');
        });

        Gate::define('edit events', function (User $user) {
            return $user->hasPermissionTo('edit events');
        });

        Gate::define('delete events', function (User $user) {
            return $user->hasPermissionTo('delete events');
        });

        Gate::define('participate events', function (User $user) {
            return $user->hasPermissionTo('participate events');
        });

        Gate::define('view cotisations', function (User $user) {
            return $user->hasPermissionTo('view cotisations');
        });

        Gate::define('create cotisation', function (User $user) {
            return $user->hasPermissionTo('create cotisation');
        });

        Gate::define('edit cotisation', function (User $user) {
            return $user->hasPermissionTo('edit cotisation');
        });

        Gate::define('delete cotisation', function (User $user) {
            return $user->hasPermissionTo('delete cotisation');
        });

        Gate::define('approve cotisation', function (User $user) {
            return $user->hasPermissionTo('approve cotisation');
        });

        Gate::define('view meetings', function (User $user) {
            return $user->hasPermissionTo('view meetings');
        });

        Gate::define('create meetings', function (User $user) {
            return $user->hasPermissionTo('create meetings');
        });

        Gate::define('edit meetings', function (User $user) {
            return $user->hasPermissionTo('edit meetings');
        });

        Gate::define('delete meetings', function (User $user) {
            return $user->hasPermissionTo('delete meetings');
        });

        Gate::define('view members', function (User $user) {
            return $user->hasPermissionTo('view members');
        });

        Gate::define('create members', function (User $user) {
            return $user->hasPermissionTo('create members');
        });

        Gate::define('edit members', function (User $user) {
            return $user->hasPermissionTo('edit members');
        });

        Gate::define('delete members', function (User $user) {
            return $user->hasPermissionTo('delete members');
        });

        Gate::define('view contributions', function (User $user) {
            return $user->hasPermissionTo('view contributions');
        });

        Gate::define('create contributions', function (User $user) {
            return $user->hasPermissionTo('create contributions');
        });

        Gate::define('edit contributions', function (User $user) {
            return $user->hasPermissionTo('edit contributions');
        });

        Gate::define('delete contributions', function (User $user) {
            return $user->hasPermissionTo('delete contributions');
        });

        Gate::define('view expenses', function (User $user) {
            return $user->hasPermissionTo('view expenses');
        });

        Gate::define('create expenses', function (User $user) {
            return $user->hasPermissionTo('create expenses');
        });

        Gate::define('edit expenses', function (User $user) {
            return $user->hasPermissionTo('edit expenses');
        });

        Gate::define('delete expenses', function (User $user) {
            return $user->hasPermissionTo('delete expenses');
        });
    }
}
