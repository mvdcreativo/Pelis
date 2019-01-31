<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //

    protected $fillable = [
        'id',
        'tmdb_id',
        'title',
        'slug',
        'backdrop_path',
        'budget',
        'imdb_id',
        'original_language',
        'original_title',
        'overview',
        'popularity',
        'poster_path',
        'release_date',
        'revenue',
        'runtime',
        'state',
        'tagline',
        'vote_average',
        'vote_count',
        'image',
        'url_dwl',
        'url_origin',
        'extid',
        'id_upload',
    ];

    // public function director()
    // {
    //     return $this->belongsTo(Director::class);
    // }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function crews()
    {
        return $this->hasMany(Crew::class);
    }

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
           return $query->where('title', 'LIKE', "%$search%");
        }
    }
}
