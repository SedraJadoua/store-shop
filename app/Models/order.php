<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class order extends Model
{
    use HasFactory;

    /**
     * The products that belong to the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(product::class, 'order_product', 'order_id', 'product_id')->withPivot('amount');
    }

    
}
