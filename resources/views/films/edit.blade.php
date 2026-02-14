@extends('layouts.bootstrap')
@section('pageTitle', 'Films')

@section('content')

    <h3 class="mb-4 fw-bold">
        🎬 @lang('messages.edit_movie')
    </h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('films.edit', ['id' => $film->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-md-3">
                <label class="form-label">@lang('messages.status')</label>
                <select name="status" class="form-select">
                    <option value="1" @selected(old('status', (int) $film->status) === 1)>
                        @lang('messages.active')
                    </option>
                    <option value="0" @selected(old('status', (int) $film->status) === 0)>
                        @lang('messages.inactive')
                    </option>
                </select>
            </div>

            <div class="col-md-9">
                <label class="form-label">@lang('messages.trailerId')</label>
                <input
                    type="text"
                    name="trailer"
                    class="form-control"
                    value="{{ old('trailer', $film->trailer) }}"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.title_ua')</label>
                <input
                    type="text"
                    name="title_ua"
                    class="form-control"
                    value="{{ old('title_ua', $film->title_ua) }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.title_en')</label>
                <input
                    type="text"
                    name="title_en"
                    class="form-control"
                    value="{{ old('title_en', $film->title_en) }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.description_ua')</label>
                <textarea name="description_ua" class="form-control"
                          rows="5">{{ old('description_ua', $film->description_ua) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.description_en')</label>
                <textarea name="description_en" class="form-control"
                          rows="5">{{ old('description_en', $film->description_en) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.poster')</label>
                <input type="file" name="poster" class="form-control" accept="image/*">

                @if($film->poster)
                    <div class="form-text">
                        @lang('messages.current'): <a href="{{ Storage::url($film->poster) }}"
                                                      target="_blank">poster</a>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">@lang('messages.screenshots')</label>
                <input type="file" name="screenshots[]" class="form-control" multiple accept="image/*">

                @if(is_array($film->screenshots) && count($film->screenshots))
                    <div class="form-text">
                        @lang('messages.current'): {{ count($film->screenshots) }}
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <label class="form-label">@lang('messages.release_date')</label>
                <input
                    type="datetime-local"
                    name="release_date"
                    class="form-control"
                    value="{{ old('release_date', optional($film->release_date)->format('Y-m-d\TH:i')) }}"
                >
            </div>

            <div class="col-md-4">
                <label class="form-label">@lang('messages.start_date')</label>
                <input
                    type="datetime-local"
                    name="start_date"
                    class="form-control"
                    value="{{ old('start_date', optional($film->start_date)->format('Y-m-d\TH:i')) }}"
                >
            </div>

            <div class="col-md-4">
                <label class="form-label">@lang('messages.end_date')</label>
                <input
                    type="datetime-local"
                    name="end_date"
                    class="form-control"
                    value="{{ old('end_date', optional($film->end_date)->format('Y-m-d\TH:i')) }}"
                >
            </div>

        </div>

        <hr class="my-5">

        @php
            $selectedDirectors = old('directors', $film->directors->pluck('id')->all());
            $selectedWriters   = old('writers',   $film->writers->pluck('id')->all());
            $selectedActors    = old('actors',    $film->actors->pluck('id')->all());
            $selectedComposers = old('composers', $film->composers->pluck('id')->all());
        @endphp

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label">🎬 @lang('messages.directors')</label>
                <select name="directors[]" class="form-select" multiple size="8">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}" @selected(in_array($person->id, $selectedDirectors))>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">✍️ @lang('messages.writers')</label>
                <select name="writers[]" class="form-select" multiple size="8">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}" @selected(in_array($person->id, $selectedWriters))>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">🧑‍🎤 @lang('messages.stars')</label>
                <select name="actors[]" class="form-select" multiple size="8">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}" @selected(in_array($person->id, $selectedActors))>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">🎼 @lang('messages.composers')</label>
                <select name="composers[]" class="form-select" multiple size="8">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}" @selected(in_array($person->id, $selectedComposers))>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-5">
            <button class="btn btn-primary px-5">
                @lang('messages.save')
            </button>
        </div>
    </form>
@endsection
