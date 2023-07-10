<?php

namespace Flexi;

use Zareismail\Cypress\Http\Requests\CypressRequest;

class Layout
{
    /**
     * Specify that the element is ready to rendering.
     */
    public static function dispaly(CypressRequest $request, array $widgets = [])
    {
        return view('flexi::layout', [
            'widgets' => $widgets,
            // 'plugins' => $widgets,
        ]);
    }
}
