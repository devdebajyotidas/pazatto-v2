<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function vendors()
    {
        return $this->hasMany('App\Models\Vendor');
    }

    public function orders()
    {
        return $this->hasManyThrough('App\Models\Order','App\Models\Vendor');
    }

    public function groups()
    {
        return $this->hasMany('App\Models\ServiceGroup');
    }
}
