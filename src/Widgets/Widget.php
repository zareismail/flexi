<?php

namespace Flexi\Widgets;

use Flexi\AuthorizedToSee;
use Flexi\Events\WidgetRendered;
use Flexi\Makeable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

abstract class Widget implements Renderable
{
    use AuthorizedToSee;
    use Makeable;

    /**
     * The unique name of the widget.
     */
    public string $name;

    /**
     * Create a new widget.
     *
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = Str::slug($name);
    }

    /**
     * Get the widget name.
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Resolve the widget data.
     */
    public function resolve($resource)
    {
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function __toString()
    {
        $content = $this->render();

        WidgetRendered::dispatch($this);

        return $content;
    }
}
