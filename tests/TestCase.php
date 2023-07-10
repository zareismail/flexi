<?php

namespace Flexi\Tests;

use Flexi\Flexi;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // Code before application created.

        Flexi::replaceResources([
            Fixtures\Grouped::class,
            Fixtures\GroupedWildcard::class,
            Fixtures\GroupedUnbounded::class,
            Fixtures\GroupedUnboundedWildcard::class,
            Fixtures\Ungrouped::class,
            Fixtures\UngroupedWildcard::class,
            Fixtures\UngroupedUnbounded::class,
            Fixtures\UngroupedUnboundedWildcard::class,
            Fixtures\Widgetized::class,
        ]);

        parent::setUp();

        $this->withoutExceptionHandling([
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        ]);

        // Code after application created.
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Flexi\ServiceProvider::class,
        ];
    }
}
