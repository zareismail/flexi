<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    {{-- loading styles --}}
    @foreach(\Flexi\Flexi::externalStyles() as $style)
        <link rel="stylesheet" href="{!! $style->url() !!}">
    @endforeach

    @if($stlyes = \Flexi\Flexi::internalStyles())
        <style>
            @foreach ($stlyes as $style)
                {!! $style->path() !!}
            @endforeach
        </style>
    @endif

    {{-- loading scripts --}}
    @foreach(collect(\Flexi\Flexi::externalScripts())->reject->isBodyScript() as $script)
        <script src="{!! $script->url() !!}"></script>
    @endforeach

    @if($scripts = collect(\Flexi\Flexi::internalScripts())->reject->isBodyScript()->toArray())
        <script>
            @foreach ($scripts as $script)
                {!! $script->path() !!}
            @endforeach
        </script>
    @endif
</head>
<body data-resource="{{ $resource->uriKey() }}">

    {{-- WIDGETS --}}
    @foreach ($widgets as $widget) {!! $widget !!}  @endforeach
    {{-- WIDGETS --}}

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>

    {{-- loading scripts --}}
    @foreach(collect(\Flexi\Flexi::externalScripts())->filter->isBodyScript() as $script)
        <script src="{!! $script->url() !!}"></script>
    @endforeach

    @if($scripts = collect(\Flexi\Flexi::internalScripts())->filter->isBodyScript()->toArray())
        <script>
            @foreach ($scripts as $script)
                {!! $script->path() !!}
            @endforeach
        </script>
    @endif
</body>
</html>
