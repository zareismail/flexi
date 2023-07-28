<?php

namespace Flexi;

use Flexi\Collections\ResourceCollection;
use Flexi\Events\FlexiServiceProviderRegistered;
use Flexi\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class PendingRouteRegistration
{
    /**
     * Indicates if the routes have been registered.
     */
    protected bool $registered = false;

    /**
     * Indicates wildcard placeholder string.
     */
    protected string $wildcardPlaceholder = 'wildcard';

    /**
     * Register the Flexi routes.
     */
    public function register(): void
    {
        Route::pattern($this->wildcardPlaceholder, '.*');

        $this->registered = true;

        app()->booted(function () {
            if (app()->runningInConsole()) {
                $this->registerRoutes();
            } else {
                Event::listen(FlexiServiceProviderRegistered::class, [$this, 'registerRoutes']);
            }
        });
    }

    /**
     * Register the Flexi routes if not cached.
     */
    public function registerRoutes(): void
    {
        Route::pattern('id', '[0-9]+');

        if (app()->routesAreCached()) {
            return;
        }

        Route::middleware(config('cypress.middleware', ['web']))
            ->group(fn ($router) => $this->mapWebRoutes());

        app('router')->getRoutes()->refreshNameLookups();
        app('router')->getRoutes()->refreshActionLookups();
    }

    /**
     * Register web routes.
     */
    public function mapWebRoutes(): void
    {
        $this
            ->groupedResources()
            ->each(function ($resources, $group) {
                Route::prefix($group)->group(function ($router) use ($resources) {
                    collect($resources)
                        ->reject(fn ($resource) => $resource === Flexi::fallbackResource())
                        ->sortBy(fn ($resource) => intval($resource::wildcard()) - intval($resource::bounded()))
                        ->each(function ($resource) use ($router) {
                            $path = '/';

                            if ($resource::bounded()) {
                                $path .= $resource::uriKey();
                            }

                            if ($resource::wildcard()) {
                                $path .= "/{{$this->wildcardPlaceholder}?}";
                            }

                            $router->get($path, [ResourceController::class, 'handle'])->name($resource::uriKey());
                        });
                });
            });
        // handle fallbacks
        if ($fallbackResource = Flexi::fallbackResource()) {
            Route::fallback([ResourceController::class, 'handle'])->name($fallbackResource::uriKey());
        }
    }

    /**
     * Get resources sorted by wildcard indicates.
     */
    public function groupedResources(): ResourceCollection
    {
        return ResourceCollection::make(Flexi::groupedResources(request()))->sortByDesc(fn ($resource, $key) => strlen($key));
    }

    /**
     * Handle the object's destruction and register the router route.
     */
    public function __destruct()
    {
        if (! $this->registered) {
            $this->register();
        }
    }
}
