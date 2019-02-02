<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Item extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'vendor_id',
        'item_category_id',
        'type',
        'image',
        'name',
        'description',
        'price',
        'offer_price',
        'type',
        'packing_charge',
        'in_stock',
        'is_archived'
    ];

    static public $rules = [
//        'restaurant_id'     => 'required|numeric',
//        'category_id'  => 'required|numeric',
//        'image'     => 'required|numeric',
//        'name'     => 'required',
//        'price'     => 'required|numeric',
//        'type'     => 'required',
//        'in_stock'     => 'numeric',
//        'is_active'  => 'numeric',
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function category(){
        return $this->belongsTo('App\Models\ItemCategory','item_category_id')->withTrashed();
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor')->withTrashed();
    }
}
