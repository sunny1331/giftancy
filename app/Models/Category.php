<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class Category extends Model
{
    protected $fillable = [
    'name',
    'slug',
    'sku_prefix',
    'next_sku_number',
    'image',
];

    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'category_attributes'
        )
        ->withPivot(
            'sort_order',
            'show_in_short_description',
            'show_in_specifications',
            'is_required'
        )
        ->withTimestamps();
    }
}

