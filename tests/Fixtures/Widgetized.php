<?php

namespace Flexi\Tests\Fixtures;

use Flexi\Http\Requests\FlexiRequest;
use Flexi\Resource;
use Flexi\Tests\Fixtures\Widgets\TestWidget;
use Illuminate\Http\Request;

class Widgetized extends Resource
{
    /**
     * Resolve the resource for incoming request.
     */
    public function resolve(FlexiRequest $request)
    {

    }

    /**
     * Get the widgets available on the entity.
     *
     * @return array
     */
    public function widgets(Request $request)
    {
        return [
            TestWidget::make('test-widget'),
        ];
    }
}
