<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

use App\Movie;
use App\Genre;
use App\Cast;
use App\Crew;

use Illuminate\Support\Str as Str;
// use App\Http\Controllers\Api\MovieController;

class ExternalIdController extends Controller
{
    //
    public function cotejarIds(){
        $movies =  Movie::all();

        $cantidad = count($movies);
        $i=0;
        foreach ($movies as $movie) {
            # code...
            $title = $movie->title;
            $id = $movie->id;
            if ($movie->tmdb_id == null) {
                $this->serchTmdbId($title, $id,$i); 
            }


        }
        echo 'Se actualizaron '.$i.' peliculas';

    }



    public function serchTmdbId($title , $id, $i){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.themoviedb.org/3/search/movie', [
            'query' => [
                'api_key'=>'5bbaf9565605b6b2d9017d357e8dd99c',
                'language' =>'es-ES',
                'query' => $title,
                'page' =>'1',
                'include_adult' => 'false',

            ]
        ]);

        if($response->getStatusCode() == 200){
            $result = json_decode($response->getBody()->getContents(), true);
            $results =  $result['results'];
            $cant = count($results);
            if($cant == 1){
                $first_res = $results[0];
                $idTmdb = $first_res['id'];

                $this->dataTmbd($idTmdb, $id);
                return $i++;

            }elseif ($cant == 0) {
                $movie = Movie::find($id);
                $movie->state =  5;
                $movie->save();
                echo "no existe con este título <br>";

            }elseif ($cant >= 2){
                $movie = Movie::find($id);
                $movie->state =  5;
                $movie->save();
                echo "tiene más de una coincidencia <br>";
            }

            // echo json_encode($results);
            // echo $idTmdb.'<br>';
            
        };


    }

    public function dataTmbd($tmdb_id, $id){

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/'.$tmdb_id, [
            'query' => [
                'api_key'=>'5bbaf9565605b6b2d9017d357e8dd99c',
                'language' =>'es-ES',
                'append_to_response' => 'credits',

            ]
        ]);

        if($response->getStatusCode() == 200){
            $result = json_decode($response->getBody()->getContents(), true);
            $results =  $result;

            ///BUSCA Y GUARDA LOS GENEROS DESDE TMDB////SE USA 1 VEZ////
            // if($result['genres'] != null){
            //     $resultG = $result['genres'];
            //     foreach ($resultG as $g) {
            //         # code...
            //         $genre = Genre::firstOrCreate(['genre_tmdb_id'=>$g['id']], $g);
            //         $genre->slug = Str::slug($g['name']);
            //         $genre->save();
                    
                    
            // //  dd($movie);
                    
            //     }

            // }
            ////////////////////////////////////////////////////////////

            $movie = Movie::find($id);
            // $movie->title =  $results['title'];
            $movie->tmdb_id =  $results['id'];
            $movie->slug = Str::slug($results['title']);
            $movie->backdrop_path =   $results['backdrop_path'];
            $movie->budget =   $results['budget'];
            $movie->imdb_id =   $results['imdb_id'];
            $movie->original_language =   $results['original_language'];
            $movie->original_title =   $results['original_title'];
            $movie->overview =   $results['overview'];
            $movie->popularity =   $results['popularity'];
            $movie->poster_path =   $results['poster_path'];
            $movie->release_date =   $results['release_date'];
            $movie->revenue =   $results['revenue'];
            $movie->runtime =   $results['runtime'];
            $movie->tagline =   $results['tagline'];
            $movie->vote_average =   $results['vote_average'];
            $movie->vote_count	 =   $results['vote_count'];
            $movie->state =  2;
            $movie->save();

            //////RELACIONAMOS LOS GENEROS
            //////CREO UN ARRAY CON LOS ID REALES DE LA BD LOCAL PARTIENDO DE EL ID DE TMDB
            $genres = [];
            foreach (array_column($results['genres'], 'id') as $gId) {
                $genre = Genre::where('genre_tmdb_id', $gId)->get();
                // echo $genre[0];
                // dd($genre);
                $genres[] = $genre[0]->id;
                
            }
            if($genres != null){
                $movie->genres()->sync($genres);
            }
            ////////////////////////////////////////////////////////////////////////////////
           

            //////buscar y guardar CAST
            $casts= $results['credits']['cast'];
            foreach ($casts as $cast) {
                $castSave = $movie->casts()->create([
                    'cast_tmdb_id' => $cast['id'],
                    'character' => $cast['character'],
                    'name' => $cast['name'],
                    'order' => $cast['order'],
                    'profile_path' => $cast['profile_path'],
                ]);
            }


            // dd($castSave);

            //////buscar y guardar CREW
            $crews= $results['credits']['crew'];
            // dd($crews);
            foreach ($crews as $crew) {
                $crewSave = $movie->crews()->create([
                    'crew_tmdb_id' => $crew['id'],
                    'departament' => $crew['department'],
                    'job' => $crew['job'],
                    'name' => $crew['name'],
                    'profile_path' => $crew['profile_path'],
                ]);
            }


            // dd($crewSave);

        }
    }
}
