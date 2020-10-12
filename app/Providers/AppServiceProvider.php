<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment() === 'production') {
            $this->app->bind('path.public', function() {
                return base_path().'/../';
            }); 
        }else {
            $this->app->bind('path.public', function() {
                return base_path().'/public/';
            }); 
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, config('app.locale'));
    }
}
