<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use App\Models\Person;
use App\Models\Tag;
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
        $people = Person::query()->orderBy('name_ua')->get();
        $tags = Tag::orderBy('name_ua')->get();

        return view('films.create', compact('people', 'tags'));
    }

    public function editView(int $id)
    {
        $film = Film::query()
            ->with(['directors', 'writers', 'actors', 'composers', 'tags'])
            ->find($id);

        if (!$film || $film->status == false) {
            abort(404);
        }

        $people = Person::query()->orderBy('name_ua')->get();
        $tags = Tag::orderBy('name_ua')->get();

        return view('films.edit', compact('people', 'film', 'tags'));
    }

    public function showView(int $id): View
    {
        $film = Film::query()->with(['directors', 'writers', 'actors', 'composers', 'tags'])->find($id);

        if (!$film || $film->status == false) {
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

        $film = Film::create($data);
        $this->setFilmRelations($film, $request);

        return redirect()->route('films.index');
    }

    public function edit(FilmRequest $request, int $id)
    {
        $data = $request->validated();

        $film = Film::query()->find($id);

        if (!$film || $film->status == false) {
            abort(404);
        }

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('films/posters', 'public');
        }

        if ($request->hasFile('screenshots')) {
            $data['screenshots'] = collect($request->file('screenshots'))
                ->map(fn($file) => $file->store('films/screenshots', 'public'))
                ->toArray();
        }

        $film->update($data);
        $this->setFilmRelations($film, $request);

        return redirect()->route('films.index');
    }

    public function destroy(Film $film)
    {
        $film->persons()->detach();
        $film->delete();

        return redirect()
            ->route('films.index')
            ->with('success', 'Film deleted successfully.');
    }

    private function setFilmRelations(Film $film, FilmRequest $request): void
    {
        $film->tags()->sync($request->input('tags', []));

        $film->setPersons($request->input('directors', []), Person::DIRECTOR);
        $film->setPersons($request->input('writers', []), Person::WRITER);
        $film->setPersons($request->input('actors', []), Person::ACTOR);
        $film->setPersons($request->input('composers', []), Person::COMPOSER);
    }
}
