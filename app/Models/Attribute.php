<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
    'name',
    'slug',
    'field_type',
    'group_name',
    'is_filterable',
    'is_active',
];

    public function values()
{
    return $this->hasMany(AttributeValue::class);
}

public function categories()
{
    return $this->belongsToMany(
        \App\Models\Category::class,
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