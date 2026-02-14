@extends('layouts.bootstrap')
@section('pageTitle', 'Films')
@php
    use Illuminate\Support\Facades\Storage;

    $posterUrl = Storage::url($film->poster);
    $screenshots = $film->screenshots;
@endphp
@section('content')
    <div class="row g-4 align-items-start">
        <div class="col-12 col-md-3 col-lg-2">
            <div class="border rounded-2 overflow-hidden">
                <img src="{{ $posterUrl }}" class="img-fluid" alt="{{ $film->title }}">
            </div>
        </div>

        <div class="col-12 col-md-9 col-lg-10">
            <h1 class="display-6 fw-semibold mb-2">
                {{ $film->title }} <span class="text-muted">({{ $film->release_date->format('Y') }})</span>
            </h1>

            <p class="text-body-secondary mb-3" style="max-width: 920px;">
                {{ $film->description }}
            </p>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge text-bg-light border fw-normal px-3 py-2">Fantasy</span>
                <span class="badge text-bg-light border fw-normal px-3 py-2">Scientist</span>
                <span class="badge text-bg-light border fw-normal px-3 py-2">Surrealism</span>
            </div>

            <div class="small">
                <div class="d-flex align-items-center mb-2">
                    <div class="fw-semibold me-2">
                        @lang('messages.directors'):
                    </div>
                    <div class="text-muted">
                        {{ $film->localizedNames('directors') }}
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <div class="fw-semibold me-2">
                        @lang('messages.writers'):
                    </div>
                    <div class="text-muted">
                        {{ $film->localizedNames('writers') }}
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <div class="fw-semibold me-2">
                        @lang('messages.stars'):
                    </div>
                    <div class="text-muted">
                        {{ $film->localizedNames('actors') }}
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="fw-semibold me-2">
                        @lang('messages.composers'):
                    </div>
                    <div class="text-muted">
                        {{ $film->localizedNames('composers') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-12 col-md-3 col-lg-2">
            <div class="d-grid gap-3">
                @foreach($screenshots as $shot)
                    <div class="border rounded-2 overflow-hidden">
                        <img
                            src="{{ Storage::url($shot) }}"
                            class="img-fluid"
                            alt="@lang('messages.screenshot')"
                        >
                    </div>
                @endforeach
            </div>
        </div>

        @php
            $now = now();
            $canShowTrailer = $film->trailer
                && $now->greaterThanOrEqualTo($film->start_date)
                && $now->lessThanOrEqualTo($film->end_date);
        @endphp

        @if($canShowTrailer)
            <div class="col-12 col-md-9 col-lg-10">
                <div class="ratio ratio-16x9 border rounded-2 overflow-hidden bg-dark">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $film->trailer }}"
                        title="@lang('messages.trailer')"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        @endif
    </div>
@endsection
