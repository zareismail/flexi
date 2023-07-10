<?php

namespace Flexi\Collections;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WidgetCollection extends Collection
{
    /**
     * Filter widgets that should be rendered for the given request.
     */
    public function authorized(Request $request): WidgetCollection
    {
        return $this->filter->authorizedToSee($request)->values();
    }

    /**
     * Resolve the widgets for display.
     */
    public function resolve($resource): WidgetCollection
    {
        return $this->each->resolve($resource);
    }
}
