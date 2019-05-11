<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
