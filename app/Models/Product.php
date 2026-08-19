<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductAttributeData;

class Product extends Model
{
    protected $fillable = [
    'category_id',
    'name',
    'slug',
    'sku',
    'description',
    'price',
    'compare_price',
    'cost_price',
    'stock',
    'manage_stock',
    'allow_backorder',
    'weight',
    'dimensions',
    'featured_image',
    'featured',
    'status',
    'meta_title',
    'meta_keywords',
    'meta_description',
    'product_type',
    'length',
    'width',
    'height',
    'track_inventory',
    'low_stock_alert',
    'continue_selling',
    'stock_status',
];

public function category()
{
    return $this->belongsTo(Category::class);
}

public function attributeData()
{
    return $this->hasMany(
        \App\Models\ProductAttributeData::class
    );
}


public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function variants()
{
    return $this->hasMany(ProductVariant::class);
}

}
