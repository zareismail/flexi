<?php

namespace Flexi\Http\Controllers;

use Flexi\Http\Requests\ResourceRequest;
use Illuminate\Routing\Controller;

class ResourceController extends Controller
{
    /**
     * Display the component through a layout.
     *
     * @return \Illuminate\View\View
     */
    public function handle(ResourceRequest $request)
    {
        $resource = $request->resolveResource();

        return view('flexi::layout', [
            'resource' => $resource,
            'widgets' => $resource->resolveWidgets($request),
        ]);

    }
}
