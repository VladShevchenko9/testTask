<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(): View
    {
        $films = Film::query()
            ->with(['directors', 'writers', 'actors', 'composers'])
            ->where('status', true)
            ->orderByDesc('films.release_date')
            ->paginate(4);

        return view('films.index', compact('films'));
    }

    public function createView()
    {
        return view('films.create');
    }

    public function showView(int $id): View
    {
        $film = Film::query()->find($id);

        if (!$film || $film->status === false) {
            abort(404);
        }

        return view('films.show', compact('film'));
    }

    public function create(FilmRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')
                ->store('films/posters', 'public');
        }

        if ($request->hasFile('screenshots')) {
            $data['screenshots'] = collect($request->file('screenshots'))
                ->map(fn($file) => $file->store('films/screenshots', 'public'))
                ->toArray();
        }

        Film::create($data);

        return redirect()
            ->route('films.index');
    }
}
