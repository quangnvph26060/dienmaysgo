<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
    ];

    public function products()
    {
        return $this->belongsToMany(SgoProduct::class, 'product_attribute_values', 'attribute_id', 'sgo_product_id')
            ->withPivot('attribute_value_id');
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
