<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeData extends Model
{
    protected $table = 'product_attribute_data';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'custom_value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function value()
    {
        return $this->belongsTo(
            AttributeValue::class,
            'attribute_value_id'
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}