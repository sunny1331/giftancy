<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeData extends Model
{
    protected $fillable = [

    'product_id',
    'attribute_id',
    'attribute_value_id',
    'custom_value',

];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(
            AttributeValue::class
        );
    }
}