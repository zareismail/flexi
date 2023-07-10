<?php

namespace Flexi\Tests\Fixtures;

use Flexi\Http\Requests\FlexiRequest;
use Flexi\Resource;

class GroupedWildcard extends Resource
{
    /**
     * Determine if the resource is a wildcard resource.
     */
    public static function wildcard(): bool
    {
        return true;
    }

    /**
     * Resolve the resource for incoming request.
     */
    public function resolve(FlexiRequest $request)
    {

    }
}
