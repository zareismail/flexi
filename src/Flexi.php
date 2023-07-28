<?php

namespace Flexi;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Flexi
{
    use InteractsWithAssets;

    /**
     * The registered resource names.
     */
    public static array $resources = [];

    /**
     * Get the current Flexi version.
     */
    public static function version(): string
    {
        return '1.1.0';
    }

    /**
     * Get the app name utilized by Flexi.
     */
    public static function name(): string
    {
        return config('flexi.name', 'Another Flexi Site');
    }

    /**
     * Get the application host name.
     */
    public static function host(): ?string
    {
        return config('flexi.host');
    }

    /**
     * Bootstrap Flexi application.
     */
    public static function boot(): void
    {
        Flexi::discover(app_path('Flexi'));
        static::routes();
    }

    /**
     * Register the Flexi routes.
     */
    public static function routes(): PendingRouteRegistration
    {
        return new PendingRouteRegistration;
    }

    /**
     * Register an event listener for the Flexi "serving" event.
     */
    public static function serving(Closure|string $callback): void
    {
        Event::listen(ServingFlexi::class, $callback);
    }

    /**
     * Register the given resources.
     */
    public static function resources(array $resources): static
    {
        static::$resources = array_unique(
            array_merge(static::$resources, $resources)
        );

        return new static;
    }

    /**
     * Replace the registered resources with the given resources.
     *
     * @return static
     */
    public static function replaceResources(array $resources)
    {
        static::$resources = $resources;

        return new static;
    }

    /**
     * Return the base collection of Flexi resources.
     *
     * @return \Flexi\ResourceCollection
     */
    public static function resourceCollection()
    {
        return Collections\ResourceCollection::make(static::$resources);
    }

    /**
     * Get the resources available for the given request.
     */
    public static function availableResources(Request $request): array
    {
        return static::resourceCollection()->all();
    }

    /**
     * Get the grouped resources available for the given request.
     */
    public static function groupedResources(Request $request): array
    {
        return Collections\ResourceCollection::make(static::availableResources($request))
            ->grouped()
            ->all();
    }

    /**
     * Get the resource class name for a given key.
     */
    public static function resourceForKey(string $key): ?string
    {
        return static::resourceCollection()->find(trim($key, '/'));
    }

    /**
     * Get the fallback resource class name.
     */
    public static function fallbackResource(): ?string
    {
        return static::resourceCollection()->fallback();
    }

    /**
     * Register all of the resource classes in the given directory.
     */
    public static function discover(string $directory, string $namespace = null)
    {
        if (! is_dir($directory)) {
            return;
        }

        $namespace = $namespace ?? app()->getNamespace();
        $resources = [];

        foreach ((new Finder)->in($directory)->files() as $resource) {
            $resource = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($resource->getPathname(), app_path().DIRECTORY_SEPARATOR)
            );

            if (is_subclass_of($resource, Resource::class) && ! (new ReflectionClass($resource))->isAbstract()) {
                $resources[] = $resource;
            }
        }

        static::resources(collect($resources)->sort()->all());
    }
}
