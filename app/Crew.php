<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    //
    protected $fillable = [
        'crew_tmdb_id',
        'departament',
        'job',
        'name',
        'profile_path',   
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

}
