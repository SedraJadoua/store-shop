<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class manger extends Model
{
    use HasFactory;
          

    protected $guarded = [];
    /**
     * Get the account that owns the manger
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(account::class, 'account_id', 'id');
    }

    /**
     * Get the store associated with the manger
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store(): HasOne
    {
        return $this->hasOne(store::class, 'manger_id', 'id');
    }

    public function scopeAccept($query)
    {
        return $query->where('isAccepted', 1);
    }    
}
