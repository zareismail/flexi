<?php

namespace Flexi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlexiRequest extends FormRequest
{
    use InteractsWithResources;

    /**
     * Determine if this request is an ResourceRequest request.
     *
     * @return bool
     */
    public function isResourceRequest()
    {
        return $this instanceof ResourceRequest;
    }
}
