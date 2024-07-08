<?php

namespace App\Providers;

use App\Services\Admin\MainService as AdminMainService;
use App\Services\Admin\MenuService as AdminMenuService;
use App\Services\Admin\V1\MainV1 as AdminMainV1;
use App\Services\Admin\V1\MenuV1 as AdminMenuV1;
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
        /** 관리자 의존성 */
        $this->bindService(AdminMainService::class, [
            'v1' => AdminMainV1::class,
        ]);
        $this->bindService(AdminMenuService::class, [
            'v1' => AdminMenuV1::class,
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
