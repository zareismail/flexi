<?php

namespace Flexi;

use Flexi\Http\Middleware\ServeFlexi;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Flexi::boot();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flexi');

        $this->app->make(HttpKernel::class)->pushMiddleware(ServeFlexi::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\ResourceMakeCommand::class,
            Console\WidgetMakeCommand::class,
        ]);
    }
}
