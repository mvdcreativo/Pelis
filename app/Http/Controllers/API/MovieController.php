<?php

namespace App\Http\Controllers\API;
use App\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Movie as MovieResource;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return MovieResource::collection(Movie::all()->where('state', 1)->sortByDesc('ano'));
        //$movies = MovieResource::With('actors','genres','director')->get();

        //return $movies;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return new MovieResource(Movie::find($id));
         
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
        try{
            $movie = Movie::find($id);
            $movie->tmdb_id = $request->get('tmdb_id');
            $movie->save();
            return $movie;            
        }catch(Exception $e) {
            return Response::json(array(
                'error' => true,
                'status_code' => 400,
                'response' => 'Ocurrió error',
            ));
        }

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
