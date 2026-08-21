<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantImage extends Model
{
    protected $fillable = [

        'product_variant_id',
        'image',
        'sort_order',
        'is_primary',

    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }
}