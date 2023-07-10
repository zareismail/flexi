<?php

namespace Flexi;

/**
 * @method static static make(string|self $name, string $path, bool $internal = false)
 */
abstract class Asset
{
    use Makeable;

    /**
     * The Assert name.
     */
    protected string $name;

    /**
     * The Asset path.
     */
    protected string $path;

    /**
     * Determine Asset is internal.
     */
    protected bool $internal = false;

    /**
     * Construct a new Asset instance.
     */
    public function __construct(string|Asset $name, string $path, bool $internal = false)
    {
        if ($name instanceof self) {
            $this->name = $name->name();
            $this->path = $name->path();
            $this->internal = $name->isInternal();

            return;
        }

        $this->name = $name;
        $this->path = $path;
        $this->internal = $internal;
    }

    /**
     * Make a internal asset.
     *
     * @return static
     */
    public static function internal(string $raw)
    {
        return new static(md5($raw), $raw, true);
    }

    /**
     * Get asset name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get asset path.
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Determine if URL is internal.
     */
    public function isInternal(): bool
    {
        return $this->internal;
    }

    /**
     * Get the Asset URL.
     */
    public function url(): string
    {
        return $this->path;
    }
}
