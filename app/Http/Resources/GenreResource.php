<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Movie;
use App\Http\Resources\MovieResourceSimple;


class GenreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=> $this->id,
            'genre_tmdb_id' => $this->genre_tmdb_id,
            'name'=> $this->name,
            'slug'=> $this->slug,
            'movies' => MovieResourceSimple::collection($this->movies),
            // 'movies' => $this->movies->paginate(2),    
        ];
    }
}
