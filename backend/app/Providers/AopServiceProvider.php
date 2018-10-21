<?php

namespace App\Providers;

use App\Aspect\LoggingAspect;
use App\Aspect\CachingAspect;
use Illuminate\Cache\Repository as CacheContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AopServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoggingAspect::class, function (Application $app) {
            return new LoggingAspect($app->make(LoggerInterface::class));
        });
        $this->app->singleton(CachingAspect::class, function (Application $app) {
            return new CachingAspect($app->make(CacheContract::class));
        });

        $this->app->tag([LoggingAspect::class, CachingAspect::class], ['goaop.aspect']);
    }
}
