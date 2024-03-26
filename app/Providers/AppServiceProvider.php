<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Services\MainService;
use App\Services\v1\MainV1;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {   
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->bind(MainService::class, function ($app) {
            $mainAbstract = $app->make(MainV1::class);

            return new MainService($mainAbstract);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            // aws alb를 위한 처리
            URL::forceScheme('https');
        }
    }
}
