<?php

namespace Flexi\Http\Middleware;

use Flexi\Events\FlexiServiceProviderRegistered;

class ServeFlexi
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if ($this->isFlexiRequest($request)) {
            FlexiServiceProviderRegistered::dispatch();
        }

        return $next($request);
    }

    /**
     * Determine if the given request is intended for Flexi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isFlexiRequest($request)
    {
        return collect(config('flexi.excepts', []))
            ->filter(fn ($path) => $request->is($path) || $request->is(trim($path.'/*', '/')))
            ->isEmpty();
    }
}
