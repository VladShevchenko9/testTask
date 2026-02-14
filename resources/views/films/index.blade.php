@extends('layouts.bootstrap')
@section('pageTitle', 'Films')
@section('content')
    <div class="row g-4">

        @forelse($films as $movie)
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="card border-0 shadow-sm h-100 movie-card">
                    @auth
                        <form
                            action="{{ route('films.destroy', $movie->id) }}"
                            method="POST"
                            class="position-absolute top-0 end-0 m-2"
                            onsubmit="return confirm('Delete this film?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger shadow-sm">
                                🗑
                            </button>
                        </form>
                    @endauth
                    <a href="{{ route('films.showView', ['id' => $movie->id]) }}">
                        <img
                            src="{{ Storage::url($movie->poster) }}"
                            class="card-img-top"
                            style="height: 340px; object-fit: cover;"
                            alt="{{ $movie->title }}"
                        >
                    </a>

                    <div class="card-body">

                        <h6 class="fw-bold mb-1">
                            {{ $movie->title }}
                        </h6>

                        <small class="text-muted">
                            {{ $movie->release_date?->format('Y') }},
                            {{ $movie->directors()->first() ?  $movie->directors()->first()->name : '—'}}
                        </small>

                    </div>

                </div>

            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h5 class="text-muted">@lang('messages.noFilms')</h5>
            </div>
        @endforelse

    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $films->links('pagination::bootstrap-5') }}
    </div>
@endsection
