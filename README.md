### [Introduction](#introduction)
### [Requirements]($requirements)
### [Installation](#installation)
### [Resources](#defining-resource)
- [Navigating](#navigating)
- [Grouping Resources](#grouping-resources)
- [Bounded Resources](#bounded-resources)
- [Wildcard Resources](#wildcard-resources)
- [Fallback Resource](#fallback-resource)
- [Resolving Resources](#resolving-resources)
### [Widgets](#widgets)
- [Defining Widgets](#defining-widgets)
- [Registering Widgets](#registering-widgets)
- [Authorization](#authorization)

### Introduction
Flexi is a powerful package designed to seamlessly integrate widgets into Laravel applications. It consists of two main components: Widgets and Resources. Widgets enable dynamic content display, while Resources provide a structured way to navigate through the application.

### Requirements
Before installing Flexi, please ensure that you have the following requirements:

- Composer
- Laravel 10.x

### Installation
To install Flexi, use the following command:

```bash
composer require zareismail/flexi
``` 

### Defining Resources
By default, Flexi resources are stored in the `app/Flexi` directory of your application. You can generate a new resource using the `flexi:resource` Artisan command:

```bash
php artisan flexi:resource Post
```

### Registering Resources
By default, all resources within the `app/Flexi` directory are automatically registered with Flexi. You can manually register resources using the `resourcesIn` or `resources` methods:

```bash
Flexi::resourcesIn(app_path('Flexi'));

Flexi::resources([ 
    Post::class,
]);
```

Make sure to include these code snippets in the `boot` method of your service provider.

### Navigating
Once you have registered your resources with Flexi, you can navigate through the application using their respective URLs. By default, the URL for accessing a generated resource combines the `resources` prefix (the default [group](#grouping-resources) name) with the resource's `uriKey`. For example, a `Post` resource would be available at `http://localhost/resources/posts`. However, you can further customize this URL.

### Grouping Resources
Each registered resource's URI path is prefixed by the `resources` key. To remove this prefix, you can edit the `group` property of the resource:

```bash  
/**
 * The logical group associated with the resource.
 */
public static ?string $group = null;
```

After this change, you can navigate to `http://localhost/posts` to access the resource.

### Bounded Resources
By default, Flexi prefixes the URL path of each registered resource with its `uriKey` (which is the pluralized slug of the class name). To remove this prefix, modify the `bounded` method of the resource:

```bash  
/**
 * Determine if the resource is a bounded resource.
 */ 
public static function bounded(): bool
{
    return false;
}
```

When `bounded` method returns `false`, Flexi removes the resource's `uriKey` from its URI. As a result, you can access the ungrouped unbounded `Post` resource using the `http://localhost/` URL.

### Wildcard Resources
By default, Flexi restricts the resource to a specific URL. However, if you want to catch any wildcard URLs for the resource, override the `wildcard` method of the resource:

```bash 
/**
 * Determine if the resource is a wildcard resource.
 */ 
public static function wildcard(): bool
{
    return true;
}
```

When `wildcard` returns `true`, Flexi dispatches all paths prefixed by the resource's `uriKey`. As a result, you can access the ungrouped wildcard `Post` resource using the `http://localhost/posts/ANYTHING` URL, where `ANYTHING` can be any string combined with the URL path separator.


### Wildcard Resources 
Laravel's fallback routes allow you to handle undefined routes or 404 errors gracefully by redirecting them to a specific route or controller action. With the new feature added to the "Flexi" package, you can now specify a fallback resource, which is a Flexi resource, to handle these fallback routes within your Laravel application.
If you want to determine a resource as fallback, override the `fallback` method of the resource:

```bash  
/**
* Determine if the resource is a fallback resource.
*/
public static function fallback(): bool
{
    return true;
}
```

This feature is handy when you want to customize the behavior of the fallback routes and provide a user-friendly experience when users encounter undefined routes or pages. pay attention that a `wildcard` `ungrouped` `unbounded` resource, also can work like a `fallback` resource.
### Resolving Resources
Each resource generated by the Flexi command contains a `resolve` method that allows you to customize data retrieval and attach it to the resource after it is resolved by the request. For example, if you need to retrieve a model from the database for the requested resource, you can do so using the following approach:

```php
use App\Models\Post;

/**
 * Resolve the resource for the incoming request.
 */
public function resolve(FlexiRequest $request)
{
    $this->post = Post::findByUri($request->segment(1));

    abort_unless($this->post, 404);
}
```

In this example, the `resolve` method retrieves a `Post` model from the database based on the URI segment of the request. It then assigns the retrieved model to the `$post` property of the resource. If the model is not found, it aborts the request with a 404 response.

You can customize the `resolve` method to suit your specific requirements, allowing you to fetch and attach relevant data to the resource based on the incoming request.

### Widgets
While the Flexi resource allows you to navigate through the application, Flexi's "Widgets" feature enables you to display data based on the navigated resources for incoming requests.

#### Defining Widgets
You can generate a widget using the `flexi:widget` Artisan command, which by default places newly generated widgets in the `app/Flexi/Widgets` directory:
```bash
php artisan flexi:widget PostDetail
```
Each widget generated by Flexi contains two methods: `resolve` and `render`. The `resolve` method prepares the relevant data for the widget before calling the `render` method, which returns the final generated content to be displayed.

```php
<?php

namespace App\Flexi\Widgets;

use Flexi\Widgets\Widget;

class PostDetail extends Widget
{
    /**
     * Resolve the widget data.
     */
    public function resolve($resource)
    {
        $this->post = $resource->post;
    }

    /**
     * Get the evaluated contents of the widget.
     *
     * @return string
     */
    public function render()
    {
        return view('post', $this->post);
    }
}
```

### Registering Widgets
Once you have defined a widget, you can attach it to a resource. Each resource generated by Flexi contains a `widgets` method. To attach a widget, simply add it to the array of widgets returned by this method. Widgets can be created using their static `make` method, typically passing the "human readable" name for the widget as an argument:

```php
/**
 * Get the widgets available on the entity.
 *
 * @return array
 */
public function widgets(Request $request)
{
    return [ 
        PostDetail::make('Post Detail'),
    ];
}
```

### Authorization

Sometimes, you may want to hide certain widgets from a group of users. You can accomplish this by using the `canSee` method chained onto your widget definition. The `canSee` method accepts a closure that should return `true` or `false`. The closure receives the incoming HTTP request, allowing you to perform authorization checks:

```php
/**
 * Get the widgets available on the entity.
 *
 * @return array
 */
public function widgets(Request $request)
{
    return [ 
        PostDetail::make('Post Detail')->canSee(fn ($request) => $request->user()->can('viewPost', $request->resolveResource()->post)),
    ];
}
```

These additional authorization checks ensure that the widget is only visible to users who meet the specified criteria.
