<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class OrderLine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'item_id',
        'item_name',
        'item_price',
        'quantity',
        'packing_charge'
    ];

    public static $rules = [
        'order_id' => 'required|numeric',
        'item_id' => 'required|numeric',
        'item_name' => 'required',
        'item_price' => 'required|numeric',
    	'quantity' => 'required|numeric',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
