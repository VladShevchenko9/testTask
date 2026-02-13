<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(): View
    {
        $films = Film::query()->orderByDesc('films.release_date')->paginate(15);

        return view('films.index', compact('films'));
    }
}
