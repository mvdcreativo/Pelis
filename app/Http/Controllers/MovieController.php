<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Genre;

use App\Http\Resources\Movie as MovieResource;
use App\Http\Resources\MovieResourceSimple;

class MovieController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $e =  $request->input('e');

        if($e == true){
            $data = Movie::Where('state',5)->orWhere('state', 2)->get();
            return $data = compact('data');
        }else{
            $movies =  MovieResourceSimple::collection(Movie::orWhere('state','=', 2)->orderBy('release_date', 'desc')->paginate(50));
            return view('movies.peliculas', compact('movies'));
            //return MovieResourceSimple::collection(Movie::where('state', 2)->orderBy('release_date', 'desc')->paginate(50) );

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $movie = new MovieResource(Movie::where('slug', '=', $slug)->firstOrFail());
        // $crews = $movie;
        $director = $movie->crews->where('job','Director');
        
        //  return $movie ;
             
         return view('movies.detalle-pelicula', compact('movie','director'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
