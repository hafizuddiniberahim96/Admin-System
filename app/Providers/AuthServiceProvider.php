<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user) {
            return $user->role->name == 'admin';
        });

        Gate::define('isUserAndAdmin', function($user) {
            return in_array($user->role->name, array('student','entrepreneur','admin'),true);
        });

        Gate::define('isUser', function($user) {
            return in_array($user->role->name, array('student','entrepreneur'),true);
        });

        Gate::define('isTutor', function($user) {
            return in_array($user->role->name, array('instructor','teacher','secretariat'),true);
        });

        Gate::define('isNotUser', function($user) {
            return in_array($user->role->name, array('instructor','teacher','secretariat','admin'),true);
        
        });

        Gate::define('isNotAdmin', function($user) {
            return in_array($user->role->name, array('student','entrepreneur','instructor','teacher','secretariat'),true);
        });
        //
    }
}
