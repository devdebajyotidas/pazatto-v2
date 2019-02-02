<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class  Customer extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = [
        'user',
//        'addresses'
    ];

//    protected $appends = [
//        'email',
//        'mobile',
//        'addresses',
//        'orders'
//    ];

    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'dob' => 'required',
        'gender' => 'required'
    ];

    public function user(){
        return $this->morphOne('App\Models\User','account');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function addresses(){
        return $this->morphMany('App\Models\Address','account');
    }
}
