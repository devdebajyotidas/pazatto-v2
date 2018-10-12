<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name'];

    public function restaurants(){
        return $this->belongsToMany('App\Models\Vendor');
    }
}
