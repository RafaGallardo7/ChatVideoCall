<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class MyAuthServiceProvider extends UserProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    public function validateCredentials(UserContract $user, array $credentials) {
        $plain = $credentials['password_hash'];        
        return ($plain == $user->password_hash);
    }

}