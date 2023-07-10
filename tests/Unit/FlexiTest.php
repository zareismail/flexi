<?php

use Flexi\Flexi;
use Flexi\Tests\Fixtures\Post;

beforeEach(function () {
    Flexi::replaceResources([]);
    Flexi::$styles = [];
    Flexi::$scripts = [];
});

test('resource registeration', function () {
    Flexi::resources([Post::class]);

    expect(Flexi::$resources)->toBeArray();
    expect(Flexi::$resources)->toContain(Post::class);
});

test('resource replacing', function () {
    Flexi::resources([Post::class]);
    Flexi::replaceResources([]);

    expect(Flexi::$resources)->toBeArray();
    expect(Flexi::$resources)->not->toContain(Post::class);
    expect(Flexi::$resources)->toBeEmpty();
});

test('create internal style', function () {
    Flexi::internalStyle('my-style', 'something');

    expect(Flexi::internalStyles())->not->toBeEmpty();
    expect(Flexi::internalStyles()[0]->path())->toBe('my-style');
    expect(Flexi::externalStyles())->toBeEmpty();
});

test('create external style', function () {
    Flexi::style('my-style', 'something');

    expect(Flexi::internalStyles())->toBeEmpty();
    expect(Flexi::externalStyles())->not->toBeEmpty();
    expect(Flexi::externalStyles()[0]->name())->toBe('my-style');
});

test('create internal script', function () {
    Flexi::internalScript('my-script', 'something');

    expect(Flexi::internalScripts())->not->toBeEmpty();
    expect(Flexi::internalScripts()[0]->path())->toBe('my-script');
    expect(Flexi::externalScripts())->toBeEmpty();
});

test('create external script', function () {
    Flexi::script('my-script', 'something');

    expect(Flexi::internalScripts())->toBeEmpty();
    expect(Flexi::externalScripts())->not->toBeEmpty();
    expect(Flexi::externalScripts()[0]->name())->toBe('my-script');
});
