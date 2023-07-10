<?php

namespace Flexi;

use Flexi\Collections\WidgetCollection;
use Flexi\Http\Requests\FlexiRequest;
use Illuminate\Http\Request;

trait ResolvesWidgets
{
    /**
     * Resolve the widgets for the given request.
     */
    public function resolveWidgets(FlexiRequest $request): WidgetCollection
    {
        return $this->availableWidgets($request)->resolve($this);
    }

    /**
     * Get the widgets that are available for the given request.
     */
    public function availableWidgets(FlexiRequest $request): WidgetCollection
    {
        return WidgetCollection::make($this->widgets($request))->authorized($request);
    }

    /**
     * Get the widgets available on the entity.
     *
     * @return array
     */
    public function widgets(Request $request)
    {
        return [];
    }
}
