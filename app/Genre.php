<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //
    protected $fillable = [
        'id', 'genre_tmdb_id', 'slug', 'name',
    ];
    
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
