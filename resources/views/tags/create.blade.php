@extends('layouts.bootstrap')
@section('pageTitle', 'Create Tag')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 fw-bold">🏷️ @lang('messages.create_tag')</h3>

        <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">
            ← @lang('messages.back')
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tags.store') }}" method="POST" class="card border-0 shadow-sm">
        @csrf

        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label">@lang('messages.slug')</label>
                    <input
                        type="text"
                        name="slug"
                        class="form-control"
                        value="{{ old('slug') }}"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">@lang('messages.title_ua')</label>
                    <input
                        type="text"
                        name="name_ua"
                        class="form-control"
                        value="{{ old('name_ua') }}"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">@lang('messages.title_en')</label>
                    <input
                        type="text"
                        name="name_en"
                        class="form-control"
                        value="{{ old('name_en') }}"
                        required
                    >
                </div>

            </div>
        </div>

        <div class="card-footer bg-transparent d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-5">
                @lang('messages.create_tag')
            </button>
        </div>
    </form>
@endsection
