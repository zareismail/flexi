<?php

namespace Flexi\Tests\Fixtures;

use Flexi\Http\Requests\FlexiRequest;
use Flexi\Resource;

class UngroupedUnbounded extends Resource
{
    /**
     * The logical group associated with the resource.
     */
    public static ?string $group = null;

    /**
     * Determine if the resource is a bounded resource.
     */
    public static function bounded(): bool
    {
        return false;
    }

    /**
     * Resolve the resource for incoming request.
     */
    public function resolve(FlexiRequest $request)
    {

    }
}
