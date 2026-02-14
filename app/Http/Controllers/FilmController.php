<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use App\Models\Person;
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

        return view('films.create', compact('people'));
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

        $film = Film::create($data);

        $directors = $this->makePersonsWithRole($request->input('directors', []), Person::DIRECTOR);
        $film->persons()->syncWithoutDetaching($directors);

        $writers = $this->makePersonsWithRole($request->input('writers', []), Person::WRITER);
        $film->persons()->syncWithoutDetaching($writers);

        $actors = $this->makePersonsWithRole($request->input('actors', []), Person::ACTOR);
        $film->persons()->syncWithoutDetaching($actors);

        $composers = $this->makePersonsWithRole($request->input('composers', []), Person::COMPOSER);
        $film->persons()->syncWithoutDetaching($composers);

        return redirect()->route('films.index');
    }

    private function makePersonsWithRole(array $ids, string $role): array
    {
        $result = [];

        foreach (array_unique($ids) as $id) {
            $id = (int)$id;

            if ($id > 0) {
                $result[$id] = ['role' => $role];
            }
        }

        return $result;
    }

    public function destroy(Film $film)
    {
        $film->persons()->detach();
        $film->delete();

        return redirect()
            ->route('films.index')
            ->with('success', 'Film deleted successfully.');
    }
}
