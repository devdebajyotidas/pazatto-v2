<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class ItemCategory extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;


    protected $fillable = [
        'vendor_id',
        'parent_id',
        'name',
        'priority',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function items(){
        return $this->hasMany('App\Models\Item','item_category_id');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }
}
