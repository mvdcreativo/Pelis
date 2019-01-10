<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;


class duplicadosController extends Controller
{
    //
    public function eliminaDuplicados()
    {
        $movies = Movie::all();
    }
}
