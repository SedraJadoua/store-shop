<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class account extends Authenticatable implements JWTSubject
{
    use HasFactory , HasApiTokens , Notifiable;

    protected $fillable = ['type'];


    /**
     * Get the user associated with the account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'account_id', 'id')->where('type' , '0');
    }

    /**
     * Get the manger associated with the account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function manger(): HasOne
    {
        return $this->hasOne(manger::class, 'account_id', 'id')->where('type' , '1');
    }


     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
