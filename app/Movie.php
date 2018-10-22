<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //

    protected $fillable = [
    	'title', 'title_origin', 'description', 'ano', 'duration', 'image', 'rating', 'url_origin', 'url_dwl', 'state', 'director_id'
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
