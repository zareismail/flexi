<?php

namespace Flexi\Events;

use Flexi\Resource;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;

class ResourceMatched
{
    use Dispatchable;

    /**
     * The resource instance.
     */
    public $resource;

    /**
     * The request instance.
     */
    public $request;

    /**
     * Create a new event instance.
     */
    public function __construct(Resource $resource, Request $request)
    {
        $this->resource = $resource;
        $this->request = $request;
    }
}
