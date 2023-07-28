<?php

namespace Flexi\Collections;

use Illuminate\Support\Collection;

class ResourceCollection extends Collection
{
    /**
     * Find a resource in the collection by key.
     */
    public function find(string $key, mixed $default = null): ?string
    {
        return $this->first(fn ($resource) => trim($resource::uriKey(), '/') === trim($key, '/'), $default);
    }

    /**
     * Find first fallback resource in the collection.
     */
    public function fallback(): ?string
    {
        return $this->first(fn ($resource) => $resource::fallback());
    }

    /**
     * Sort the resources by their group property.
     */
    public function grouped(): ResourceCollection
    {
        return new static($this->groupBy(fn ($resource) => $resource::group())->toBase()->sortKeys());
    }
}
