<?php

namespace App\Providers;

use App\Abstracts\MainAbstract;
use App\Abstracts\MenuAbstract;
use App\Services\MainService;
use App\Services\MenuService;
use App\Services\v1\MainV1;
use App\Services\v1\MenuV1;
use Illuminate\Support\Facades\Route;
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
        
        $this->bindService(MainService::class, [
            'v1' => MainV1::class,
        ]);
        $this->bindService(MenuService::class, [
            'v1' => MenuV1::class,
        ]);
    }

    protected function bindService(string $abstractClass, array $versionedClassMap): void
    {
        $this->app->bind($abstractClass, function ($app) use ($versionedClassMap, $abstractClass) {
            $routeName    = Route::currentRouteName();
            $routeParts   = explode(".", $routeName);
            $routeVersion = $routeParts[0] ?? null;     // 'v1'을 추출

            $abstract = null;
            if (isset($versionedClassMap[$routeVersion])) {
                $abstract = $app->make($versionedClassMap[$routeVersion]);
            }

            return new $abstractClass($abstract);
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
