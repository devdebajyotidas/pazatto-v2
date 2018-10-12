<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Discount extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'service_id',
        'vendor_id',
        'customer_id',
        'discountable_model',
        'discountable_type',
        'discountable_id',
        'max_use_customer',
        'max_use_device',
        'valid_from',
        'expires_on',
        'min_order_amount',
        'quantity_required',
        'quantity_discounted',
        'discount_operation',
        'discount_value',
        'is_first_order_only',
        'max_usage',
        'is_featured',
        'feature_image',
        'is_active',
        'is_approved'
    ];

    static $rules = [
//        'code'  => 'required|unique:discounts',
//        'title' => 'required',
//        'description' => 'required',
//        'mode' => 'required|in:OFFER,COUPON',
//        'customers' => 'required',
//        'restaurants' => 'required',
//        'applicable_on' => 'required',
//        'max_use_customer' => 'numeric',
//        'max_use_device' => 'numeric',
//        'min_order_amount' => 'numeric',
//        'discount_type' => 'required|in:FIXED,PERCENTAGE',
//        'discount_value' => 'numeric',
//        'valid_from' => 'date',
//        'expires_on' => 'date',
//        'is_active' => 'numeric',
//        'is_approved' => 'numeric',
//        'is_featured' => 'numeric'
    ];


    public function service(){
        return $this->belongsTo('App\Models\Service');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }

    public function customer(){
        return $this->belongsTo('App\Models\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'coupon', 'code');
    }

}
