<?php

use Flexi\Events\ResourceMatched;
use Flexi\Events\WidgetRendered;
use Flexi\Flexi;
use Flexi\Tests\Fixtures\Grouped;
use Flexi\Tests\Fixtures\GroupedWildcard;
use Flexi\Tests\Fixtures\GroupedUnbounded;
use Flexi\Tests\Fixtures\GroupedUnboundedWildcard;
use Flexi\Tests\Fixtures\Ungrouped;
use Flexi\Tests\Fixtures\UngroupedWildcard;
use Flexi\Tests\Fixtures\UngroupedUnbounded;
use Flexi\Tests\Fixtures\UngroupedUnboundedWildcard;
use Flexi\Tests\Fixtures\Widgetized;
use Flexi\Tests\Fixtures\Widgets\TestWidget;
use Illuminate\Support\Facades\Event;

uses(\Flexi\Tests\TestCase::class);

// test grouped resources
it('find grouped resources', function () {
    Event::fake();

    Flexi::replaceResources([Grouped::class]);

    $this->get(Grouped::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === Grouped::uriKey());
    $this->get(Grouped::uri().'/'.time())->assertStatus(404);
});

it('find grouped wildcard resources', function () {
    Event::fake();

    $this->get(GroupedWildcard::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === GroupedWildcard::uriKey());

    $this->get(GroupedWildcard::uri().'/'.time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === GroupedWildcard::uriKey());
});

it('find grouped unbounded resources', function () {
    Event::fake();

    $this->get(GroupedUnbounded::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === GroupedUnbounded::uriKey());
    $this->get(GroupedUnbounded::uri().'/'.time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() !== GroupedUnbounded::uriKey());
});

it('find grouped bounded wildcard resources', function () {
    Event::fake();

    $this->get(GroupedUnboundedWildcard::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === GroupedUnboundedWildcard::uriKey());

    $this->get(GroupedUnboundedWildcard::uri().'/'.time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === GroupedUnboundedWildcard::uriKey());
});

// test ungrouped resources
it('find ungrouped resources', function () {
    Event::fake();

    Flexi::replaceResources([Ungrouped::class]);

    $this->get(Ungrouped::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === Ungrouped::uriKey());
    $this->get(Ungrouped::uri().'/'.time())->assertStatus(404);
});

it('find ungrouped wildcard resources', function () {
    Event::fake();

    $this->get(UngroupedWildcard::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === UngroupedWildcard::uriKey());

    $this->get(UngroupedWildcard::uri().'/'.time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === UngroupedWildcard::uriKey());
});

it('find ungrouped unbounded resources', function () {
    Event::fake();

    $this->get(UngroupedUnbounded::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === UngroupedUnbounded::uriKey());
    $this->get(UngroupedUnbounded::uri().'/'.time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() !== UngroupedUnbounded::uriKey());
});

it('find ungrouped unbounded wildcard resources', function () {
    Event::fake();

    $this->get(time())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === UngroupedUnboundedWildcard::uriKey());
});

it('renders widgets in the resources', function () {
    Event::fake();

    $this->get(Widgetized::uri())->assertStatus(200);
    Event::assertDispatched(ResourceMatched::class, fn ($event) => $event->resource->uriKey() === Widgetized::uriKey());
    Event::assertDispatched(WidgetRendered::class, fn ($event) => $event->widget instanceof TestWidget);
});
