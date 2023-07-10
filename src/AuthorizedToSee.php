<?php

namespace Flexi;

use Closure;
use Illuminate\Http\Request;

trait AuthorizedToSee
{
    /**
     * The callback used to authorize viewing the resource.
     */
    public ?Closure $seeCallback = null;

    /**
     * Determine if the resource should be available for the given request.
     */
    public function authorizedToSee(Request $request): bool
    {
        return $this->seeCallback ? call_user_func($this->seeCallback, $request) : true;
    }

    /**
     * Set the callback to be run to authorize viewing the resource.
     */
    public function canSee(Closure $callback): static
    {
        $this->seeCallback = $callback;

        return $this;
    }
}
