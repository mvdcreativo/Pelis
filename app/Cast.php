<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    //
    protected $fillable = [
        'cast_tmdb_id',
        'character',
        'name',
        'order',
        'profile_path',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
