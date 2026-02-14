<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    @yield('customStyles')
    <title>@yield('pageTitle', 'Laravel App')</title>
</head>
<body class="app-bg">
@section('navbar')
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            @auth
                @php
                    $user = auth()->user();
                @endphp

                @lang('messages.welcome', ['name' => $user->name])
            @endauth

            @guest
                <span class="navbar-brand">Movie App</span>
            @endguest

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar"
                aria-controls="navbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                           href="{{ route('films.index') }}">@lang('messages.home')</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="{{ route('films.createView') }}">@lang('messages.createFilm')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="{{ route('tags.index') }}">@lang('messages.tags')</a>
                        </li>
                    @endauth
                </ul>
                <div class="d-flex align-items-center mx-3">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if ($localeCode !== app()->getLocale())
                            <a href="{{ route('switch.language', $localeCode) }}"
                               class="btn btn-outline-secondary btn-sm mx-1">
                                {{ strtoupper($localeCode) }}
                            </a>
                        @endif
                    @endforeach
                </div>
                @auth
                    <form class="d-flex" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link p-0">
                            @lang('messages.logout')
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
@show
<br>
<div class="container">
    @yield('content')
</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"
></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
@yield('customScripts')
</body>
</html>
