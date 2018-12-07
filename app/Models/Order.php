<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Order extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'customer_id',
        'vendor_id',
        'agent_id',
        'delivery_location',
        'delivery_type',
        'customer_note',
        'vendor_note',
        'sub_total',
        'delivery_charge',
        'packing_charge',
        'tax',
        'discount',
        'discount_code',
        'total',
        'payment_method',
        'status',
        'device_id',
        'coupon'
    ];

    public static $rules = [
        'customer_id' => 'required|numeric',
        'restaurant_id' => 'required|numeric',
        'delivery_charge' => 'required|numeric',
        'tax' => 'required|numeric',
        'payment_method' => 'required',
        'status' => 'required|numeric',
        'order_type' => 'required',
        'delivery_type' => 'required'
    ];

    protected $hidden = [
    ];


    public function lines(){
        return $this->hasMany('App\Models\OrderLine');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor')->withTrashed();
    }

    public function agent(){
        return $this->belongsTo('App\Models\Agent');
    }
}
