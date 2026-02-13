@extends('layouts.bootstrap')

@section('navbar')
    @php
        $user = auth()->user();
    @endphp

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <span class="navbar-brand">@lang('messages.welcome', ['name' => $user->name])</span>

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
                        <a class="nav-link active" aria-current="page" href="#">@lang('messages.home')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('films.createView') }}">@lang('messages.createFilm')</a>
                    </li>
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
                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link p-0">
                        @lang('messages.logout')
                    </button>
                </form>
            </div>
        </div>
    </nav>
@endsection
