<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link type="image/x-icon" href="/img/favicon-raum-128.png" rel="shortcut icon">
    <link type="image/x-icon" href="/img/favicon-raum-128.png" rel="icon">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon-raum-128.png">

    <x-embed-codes position="head" />

    <script src="https://kit.fontawesome.com/223d2a834c.js" crossorigin="anonymous"></script>

    @routes

    <x-translations />
    
    <x-shared />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @inertiaHead
</head>

<body class="w-full" id="body">
<x-embed-codes position="body_begin" />

@inertia

<x-embed-codes position="body_end" />
</body>
</html>
