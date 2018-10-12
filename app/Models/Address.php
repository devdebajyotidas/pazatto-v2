<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Address extends Model implements  AuditableContract
{
    use SoftDeletes;
    use Auditable;

    protected $fillable = [
        'account_id',
        'account_type',
        'latitude',
        'longitude',
        'landmark',
        'apartment',
        'building',
        'street',
        'locality',
        'city',
        'state',
        'postal_code',
        'formatted_address',
        'is_primary'
    ];

    public function account()
    {
        return $this->morphTo('account');
    }

}
