<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //

    protected $fillable = [
        'title', 
        'title_origin', 
        'description', 
        'ano', 
        'duration', 
        'image', 
        'rating', 
        'url_origin', 
        'url_dwl', 
        'extid', 
        'state', 
        'director_id', 
        'id_upload', 
        'tmdb_id',
        'imdb_id', 
        'image_bg',
        'rating_tmdb',
        'rating_imdb',
        'vote_count_tmdb',
        'vote_count_imdb',
        'release_date',
        'budget',
        'revenue'
    ];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}
