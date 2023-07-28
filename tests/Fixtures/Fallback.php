<?php

namespace Flexi\Tests\Fixtures;

use Flexi\Http\Requests\FlexiRequest;
use Flexi\Resource;

class Fallback extends Resource
{
    /**
     * Determine if the resource is a fallback resource.
     */
    public static function fallback(): bool
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
