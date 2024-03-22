<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class color extends Model
{
    use HasFactory;

    protected $fillable = ['color'];


    /**
     * Get all of the products for the color
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(product::class, 'color_id', 'id');
    }
    
}
