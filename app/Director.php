<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //
    protected $fillable = [
    	'name'
    ];

    public function genres()
    {
        return $this->hasMany(Movie::class);
    }


}
