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
     * Find first wildcard resource in the collection.
     */
    public function wildcard(): ?string
    {
        return $this->first(fn ($resource) => $resource::wildcard());
    }

    /**
     * Sort the resources by their group property.
     */
    public function grouped(): ResourceCollection
    {
        return new static($this->groupBy(fn ($resource) => $resource::group())->toBase()->sortKeys());
    }
}
