<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Http\Resources\MovieResourceSimple;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $search = $request->get('search');

        $movies =  Movie::orderBy('release_date', 'desc')
            ->Search($search)
            ->where('state','=', 2)
            ->paginate(50);
        $search = true;

        return view('movies.peliculas', compact('movies', 'search'));
    }
}
