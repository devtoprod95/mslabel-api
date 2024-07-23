<?php

namespace App\Providers;

use App\Services\Admin\BoardService;
use App\Services\Admin\MainService;
use App\Services\Admin\MenuService;
use App\Services\Admin\V1\BoardV1;
use App\Services\Admin\V1\MainV1;
use App\Services\Admin\V1\MenuV1;
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
        $this->bindService(MainService::class, [
            'v1' => MainV1::class,
        ]);
        $this->bindService(MenuService::class, [
            'v1' => MenuV1::class,
        ]);
        $this->bindService(BoardService::class, [
            'v1' => BoardV1::class,
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
