<?php

namespace Flexi\Widgets;

class Html extends Widget
{
    /**
     * The widget content.
     */
    protected string $content = '';

    /**
     * Set the widget content.
     */
    public function content(string $content): Html
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->content;
    }
}
