<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>

    <link rel="shortcut icon" type="image/x-icon" href="{{ Vite::asset('resources/icons/favicon.ico') }}">

    @vite('resources/scss/app.scss')

    @inertiaHead
</head>
<body>
@inertia

@vite('resources/js/app.js')
</body>
</html>
