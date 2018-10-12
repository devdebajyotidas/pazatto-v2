<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements AuditableContract, UserResolver
{
    use Notifiable;
    use SoftDeletes;
    use Auditable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile',
        'email',
        'password',
        'account_id',
        'account_type',
        'fcm_token',
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $rules = [
        'mobile' => 'required|unique:users',
        'email' => 'required|unique:users',
        'api_token' => 'required|unique:users'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function account()
    {
        return $this->morphTo('account');
    }

    public function oauth()
    {
        return $this->hasOne('App\Models\OAuthProvider');
    }

    /**
     * {@inheritdoc}
     */
    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
}
