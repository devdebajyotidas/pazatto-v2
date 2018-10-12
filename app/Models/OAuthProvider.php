<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'auth_id',
        'auth_type',
        'auth_data'
    ];

    /**
     * The validation rules for the attributes
     *
     * @var array
     */
    static public $rules = [
        'user_id' => 'required|numeric',
        'auth_id'     => 'required|unique:auth_providers',
        'auth_type'     => 'required|in:facebook,google'
    ];

    /**
     * Get the user that has the auth provider.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
