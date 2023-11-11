<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/main.css" rel="stylesheet">

    <title>IIS_IoT_system</title>
</head>
<body>
<x-error-box></x-error-box>
<x-success-box></x-success-box>
@yield('login-reg-body')
</body>
