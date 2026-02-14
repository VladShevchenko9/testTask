@extends('layouts.bootstrap')
@section('pageTitle', 'Films')
@section('content')
    <div class="row g-4">

        @forelse($films as $movie)
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="card border-0 shadow-sm h-100 movie-card position-relative">
                    @auth
                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-2">
                            <a
                                href="{{ route('films.editView', ['id' => $movie->id]) }}"
                                class="btn btn-sm btn-warning shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 36px; height: 36px;"
                                title="Edit"
                            >
                                ✏
                            </a>

                            <form
                                action="{{ route('films.destroy', $movie->id) }}"
                                method="POST"
                                class="m-0"
                                onsubmit="return confirm('Delete this film?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;"
                                    title="Delete"
                                >
                                    🗑
                                </button>
                            </form>
                        </div>
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
                            {{ $movie->directors()->first()?->name ?? '—' }}
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
