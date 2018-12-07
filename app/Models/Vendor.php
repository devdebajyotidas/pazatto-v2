<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Vendor extends Model implements AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'service_id',
        'service_areas',
        'name',
        'featured_image',
        'contact_phone',
        'contact_email',
        'contact_person',
        'address',
        'coordinates',
        'min_order',
        'average_cost',
        'has_delivery',
        'has_takeaway',
        'average_delivery_time',
        'free_delivery_range',
        'paid_delivery_range',
        'delivery_charge',
        'open_time',
        'close_time',
        'happy_hour_start',
        'happy_hour_end',
        'pazatto_commission',
        'customer_commission',
        'tax',
        'is_taking_orders',
        'highlights',
        'category'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = [
//        'user'
    ];

    protected $appends = [
        'is_open_now',
        'in_range'
//        'highlights',
//        'category'
    ];

    public function groups() {
        return $this->belongsToMany(Group::class);
    }

    public function user()
    {
        return $this->morphOne('App\Models\User','account');
    }

    public function photos()
    {
        return $this->belongsToMany('App\Models\Image','vendor_images');
    }

    public function locations()
    {
        return $this->morphMany('App\Models\Address','account');
    }

    public function menu()
    {
        $customerCommission = $this->getAttribute('customer_commission') ? $this->getAttribute('customer_commission') : 0;

//        return $this->load(['categories' => function($query) {
//            return $query->orderByRaw('ISNULL(priority), priority ASC');
//        }, 'categories.items' => function($query) use($customerCommission)
//        {
//            $query->selectRaw("items.*");
//            $query->selectRaw("CEIL( items.price + ( $customerCommission/100 ) * items.price ) as price");
//            $query->selectRaw("CEIL( items.offer_price + ( $customerCommission/100 ) * items.offer_price ) as offer_price");
//        }]);
        return $this->categories()
//            ->orderBy('id', 'DESC')
            ->orderByRaw('ISNULL(priority), priority ASC')
//            ->orderBy('created_at', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->with(
            [
                'items' => function($query) use($customerCommission)
                {
                    $query->selectRaw("items.*");
                    $query->selectRaw("CEIL( items.price + ( $customerCommission/100 ) * items.price ) as price");
                    $query->selectRaw("CEIL( items.offer_price + ( $customerCommission/100 ) * items.offer_price ) as offer_price");
                }
            ]
        );
    }

    public function categories()
    {
        return $this->hasMany('App\Models\ItemCategory');
    }

    public function items()
    {
        return $this->hasManyThrough('App\Models\Item','App\Models\ItemCategory');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function agents()
    {
        return $this->belongsToMany('App\Models\Agent');
    }

    public function getIsOpenNowAttribute()
    {
//        if($this->attributes['is_taking_order'])
//        $now = Carbon::now()->format('h:i');
        date_default_timezone_set("Asia/Kolkata");
        $now = time();
        $open = $this->open_time;
        $close = $this->close_time;

        $now = (new DateTime())->setTimestamp($now);

        $startTime = DateTime::createFromFormat('H:i:s', $open);
        $endTime   = DateTime::createFromFormat('H:i:s', $close);

//        return $now. ',' . $startTime . '.' . $endTime;
        // check if current time is within a range
        if (($startTime < $now) && ($now < $endTime)) {
            return $this->is_taking_orders;
        }
        return 0;
    }

    public function getInRangeAttribute()
    {
//        dd(session('coordinates'));
        return 2; //rand(0,1);
    }

//    public function getHighlightsAttribute()
//    {
//        return ["Chinese", 'North Indian', 'Bengali', 'Mineral Water'];
//    }

//    public function getCategoryAttribute()
//    {
//        return ["Pure Veg", "Veg/Non-Veg", "Aquafina", "Kinley", "Bislery"][rand(0,4)];
//    }
}
