<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name.' '.Auth::user()->surname }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('home') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('dashboard-form').submit();">
                                    {{ __('Dashboard') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="dashboard-form" action="{{ route('home') }}" method="GET" class="d-none">
                                    @csrf
                                </form>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container py-4">
            <div class="pt-1 p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Custom jumbotron</h1>
                    <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the
                        one in previous versions of Bootstrap. Check out the examples below for how you can remix and
                        restyle it to your liking.</p>
                    <button class="btn btn-primary btn-lg" type="button">Example button</button>
                </div>
            </div>

            <div class="row align-items-md-stretch">
                <div class="col-md-6">
                    <div class="h-100 p-4 text-bg-dark rounded-3">
                        <h2>Change the background</h2>
                        <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron
                            look. Then, mix and match with additional component themes and more.</p>
                        <button class="btn btn-outline-light" type="button">Example button</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="h-100 p-4 bg-light border rounded-3">
                        <h2>Add borders</h2>
                        <p>Or, keep it light and add a border for some added definition to the boundaries of your
                            content. Be sure to look under the hood at the source HTML here as we've adjusted the
                            alignment and sizing of both column's content for equal-height.</p>
                        <button class="btn btn-outline-secondary" type="button">Example button</button>
                    </div>
                </div>
            </div>

            <footer class="pt-3 mt-4 text-muted border-top">
                © 2023
            </footer>
        </div>
    </main>
</div>
</body>
</html>
