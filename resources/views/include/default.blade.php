<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/main.css" rel="stylesheet">

    <title>IIS_IoT_system</title>
</head>
<body>
    <div class="menu">
        <!-- Back button removed, no usage-->
        <a href="/systems">Systems</a>
        @if(Auth::user()['admin'] === 1)
            <a href="/admin">Admin site</a>
        @endif
        <a class="logout-button" href="/logout">Logout</a>
    </div>
    <x-error-box></x-error-box>
    <x-success-box></x-success-box>
@yield('default-site-body')
</body>
