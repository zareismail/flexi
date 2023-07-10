<?php

namespace Flexi\Events;

use Flexi\Widgets\Widget;
use Illuminate\Foundation\Events\Dispatchable;

class WidgetRendered
{
    use Dispatchable;

    /**
     * The widget instance.
     */
    public $widget;

    /**
     * Create a new event instance.
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }
}
