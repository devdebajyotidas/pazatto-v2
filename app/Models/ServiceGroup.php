<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'name'
    ];

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
