<?php

namespace Flexi;

trait InteractsWithAssets
{
    /**
     * All of the registered Flexi scripts.
     *
     * @var array<int, \Flexi\Script>
     */
    public static array $scripts = [];

    /**
     * All of the registered Flexi CSS.
     *
     * @var array<int, \Flexi\Style>
     */
    public static array $styles = [];

    /**
     * Get all of the additional scripts that should be registered.
     *
     * @return array<int, \Flexi\Script>
     */
    public static function allScripts()
    {
        return static::$scripts;
    }

    /**
     * Get all of the internal scripts that should be registered.
     *
     * @return array<int, \Flexi\Script>
     */
    public static function internalScripts()
    {
        return collect(static::$scripts)->filter->isInternal()->toArray();
    }

    /**
     * Get all of the external scripts that should be registered.
     *
     * @return array<int, \Flexi\Script>
     */
    public static function externalScripts()
    {
        return collect(static::$scripts)->reject->isInternal()->toArray();
    }

    /**
     * Get all of the additional stylesheets that should be registered.
     *
     * @return array<int, \Flexi\Style>
     */
    public static function allStyles()
    {
        return static::$styles;
    }

    /**
     * Get all of the internal stylesheets that should be registered.
     *
     * @return array<int, \Flexi\Style>
     */
    public static function internalStyles()
    {
        return collect(static::$styles)->filter->isInternal()->toArray();
    }

    /**
     * Get all of the external stylesheets that should be registered.
     *
     * @return array<int, \Flexi\Style>
     */
    public static function externalStyles()
    {
        return collect(static::$styles)->reject->isInternal()->toArray();
    }

    /**
     * Register the given internal script with Flexi.
     *
     * @return static
     */
    public static function internalScript(string $raw)
    {
        return static::script(Script::internal($raw), $raw);
    }

    /**
     * Register the given script file with Flexi.
     *
     * @return static
     */
    public static function script(string|Script $name, string $path)
    {
        static::$scripts[] = new Script($name, $path);

        return new static();
    }

    /**
     * Register the given script file with Flexi.
     *
     * @return static
     */
    public static function prependScript(string|Script $name, string $path)
    {
        static::$scripts = array_merge([new Script($name, $path)], (array) static::$scripts);

        return new static();
    }

    /**
     * Register the given internal CSS with Flexi.
     *
     *
     * @return static
     */
    public static function internalStyle(string $raw)
    {
        return static::style(Style::internal($raw), $raw);
    }

    /**
     * Register the given CSS file with Flexi.
     *
     * @return static
     */
    public static function style(string|Style $name, string $path)
    {
        static::$styles[] = new Style($name, $path);

        return new static();
    }
}
