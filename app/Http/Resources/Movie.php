<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DirectorResource;

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
            'title' => $this->title,
            'title_origin' =>$this->title_origin,
            'description' =>$this->description,
            'ano' =>$this->ano,
            'duration' =>$this->duration,
            'image' =>$this->image,
            'rating' =>$this->rating,
            'url_origin' =>$this->url_origin,
            'url_dwl' =>$this->url_dwl,
            'state' =>$this->state,
            'id_upload' =>$this->id_upload,
            'director' => new DirectorResource($this->director),
            'actors' =>$this->actors,
            'genres' =>$this->genres,
            'extid' =>$this->extid,
        ];
    }
}
