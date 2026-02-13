@extends('layouts.bootstrap')

@section('pageTitle', 'Login')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <div class="card card-light shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h1 class="h4 mb-1">@lang('messages.singIn')</h1>
                        <div class="text-muted small">@lang('messages.enterCredentials')</div>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger small">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('messages.email')</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autofocus
                            >
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">@lang('messages.password')</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            @lang('messages.login')
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
