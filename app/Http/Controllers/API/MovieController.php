<?php

namespace App\Http\Controllers\API;
use App\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        //
        $e =  $request->input('e');

        if($e == true){
            $data = Movie::Where('state',5)->orWhere('state', 2)->get();
            return $data = compact('data');
        }else{
            return MovieResourceSimple::collection(Movie::where('state', 2,1)->paginate(50));
            //return MovieResourceSimple::collection(Movie::where('state', 2)->orderBy('release_date', 'desc')->paginate(50) );

        }
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
        // $data =  Movie::where('tmdb_id', $idTmdb)->get();

        // return $data = compact('data');
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
            $movie->tmdb_id = $request->input('tmdb_id');
            $movie->release_date = $request->input('release_date');

            $movie->state = 1;
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
