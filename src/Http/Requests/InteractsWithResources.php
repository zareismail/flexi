<?php

namespace Flexi\Http\Requests;

use Flexi\Events\ResourceMatched;
use Flexi\Flexi;

trait InteractsWithResources
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Resolve the resource instance being requested.
     */
    public function resolveResource(): mixed
    {
        return once(fn () => tap($this->newResource(), function ($resource) {
            $resource->resolve($this);
            ResourceMatched::dispatch($resource, $this);
        }));
    }

    /**
     * Return a resource instance.
     *
     * @return \Flexi\Resource
     */
    public function newResource()
    {
        return app()->make($this->resource());
    }

    /**
     * Get the class name of the resource being requested.
     *
     * @return mixed
     */
    public function resource()
    {
        return tap($this->matchedResource() ?? Flexi::wildcardResource(), function ($resource) {
            abort_if(is_null($resource), 404);
        });
    }

    /**
     * Get the class name of the resource that matches the request.
     *
     * @return mixed
     */
    public function matchedResource()
    {
        return Flexi::resourceForKey($this->route()->getName());
    }
}
