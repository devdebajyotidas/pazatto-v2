<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
    ];

    public function user()
    {
        return $this->morphOne('App\Models\User','account');
    }

    public function vendors()
    {
        return $this->belongsToMany('App\Models\Vendor');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
