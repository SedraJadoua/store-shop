<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return asset('storage/product/' . $value);
    }
    /**
     * The order that belong to the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order(): BelongsToMany
    {
        return $this->belongsToMany(order::class, 'order_product', 'product_id', 'order_id');
    }

    /**
     * Get the type that owns the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(type::class, 'type_id');
    }

    /**
     * Get the color that owns the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(color::class, 'color_id');
    }

    /**
     * Get the store that owns the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(store::class, 'store_id');
    }
}
