<?php

namespace Flexi;

use Flexi\Http\Requests\FlexiRequest;
use Illuminate\Support\Str;

abstract class Resource
{
    use ResolvesWidgets;

    /**
     * The logical group associated with the resource.
     */
    public static ?string $group = 'resources';

    /**
     * Get the logical group associated with the resource.
     */
    public static function group(): ?string
    {
        return static::$group;
    }

    /**
     * Determine if the resource is a wildcard resource.
     */
    public static function wildcard(): bool
    {
        return false;
    }

    /**
     * Determine if the resource is a bounded resource.
     */
    public static function bounded(): bool
    {
        return true;
    }

    /**
     * Get the resource name.
     */
    public static function name(): string
    {
        return class_basename(get_called_class());
    }

    /**
     * Get the URI key for the resource.
     */
    public static function uriKey(): string
    {
        return Str::plural(Str::kebab(class_basename(get_called_class())));
    }

    /**
     * Get the URI for the resource.
     */
    public static function uri(): string
    {
        return implode('/', array_filter([static::group(), static::bounded() ? static::uriKey() : null])) ?: '/';
    }

    /**
     * Resolve the resource for incoming request.
     */
    abstract public function resolve(FlexiRequest $request);
}
