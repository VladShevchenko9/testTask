@extends('layouts.bootstrap')
@section('pageTitle', 'Tags')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 fw-bold">🏷️ @lang('messages.tags')</h3>

        <a href="{{ route('tags.create') }}" class="btn btn-primary">
            + @lang('messages.create_tag')
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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th style="width: 220px;">@lang('messages.slug')</th>
                        <th>@lang('messages.title_ua')</th>
                        <th>@lang('messages.title_en')</th>
                        <th class="text-end" style="width: 140px;">@lang('messages.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td><span class="badge text-bg-secondary">{{ $tag->slug }}</span></td>
                            <td>{{ $tag->name_ua }}</td>
                            <td>{{ $tag->name_en }}</td>
                            <td class="text-end">
                                <form
                                    action="{{ route('tags.destroy', $tag) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        🗑 @lang('messages.delete')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                @lang('messages.noTags')
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $tags->links('pagination::bootstrap-5') }}
    </div>
@endsection
