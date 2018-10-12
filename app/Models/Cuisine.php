<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Cuisine extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['created_at','updated_at','deleted_at'];

    public function vendors(){
        return $this->belongsToMany('App\Models\Vendor');
    }
}
