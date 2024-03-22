<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class store extends Model
{
    use HasFactory;
    protected $fillable = ['photo' , 'store_name'];
    /**
     * Get all of the products for the store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(product::class, 'store_id', 'id');
    }

    /**
     * Get the manger that owns the store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manger(): BelongsTo
    {
        return $this->belongsTo(manger::class, 'manger_id', 'id');
    }
     
    // public function setPhotoAttribute($value){
    //   $name = basename($value);
    //   $this->attributes['photo'] = $name;
    // }

    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return asset('storage/store/' . $value);
    }
}
