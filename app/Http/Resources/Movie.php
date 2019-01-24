<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Cast as CastResource;
use App\Http\Resources\CrewResource;
use App\Http\Resources\GenreResourceCollection;


use App\Crew;
use App\Cast;

class Movie extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tmdb_id'=> $this->tmdb_id,
            'slug'=> $this->slug,
            'title' => $this->title,
            'backdrop_path' =>$this->backdrop_path,
            'budget' =>$this->budget,
            'imdb_id' =>$this->imdb_id,
            'original_language' =>$this->original_language,
            'original_title' =>$this->original_title,
            'overview' =>$this->overview,
            'popularity' =>$this->popularity,
            'poster_path' =>$this->poster_path,
            'release_date' =>$this->release_date,
            'revenue' =>$this->revenue,
            'runtime' =>$this->runtime,
            'state' =>$this->state,
            'tagline' =>$this->tagline,
            'vote_average' =>$this->vote_average,
            'vote_count' =>$this->vote_count,
            'image' =>$this->image,
            'url_dwl' =>$this->url_dwl,
            'url_origin' =>$this->url_origin,
            'extid' =>$this->extid,
            'id_upload' =>$this->id_upload,
            'genres' => $this->genres,
            'casts' => $this->casts,
            'crew' => $this->crews,
                
            
        ];
    }
}
