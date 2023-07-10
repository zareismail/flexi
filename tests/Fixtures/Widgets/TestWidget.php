<?php

namespace Flexi\Tests\Fixtures\Widgets;

use Flexi\Widgets\Widget;

class TestWidget extends Widget
{
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return static::name();
    }
}
