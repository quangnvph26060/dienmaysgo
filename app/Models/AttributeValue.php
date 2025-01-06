<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(SgoProduct::class, 'product_attribute_values', 'attribute_value_id', 'sgo_product_id');
    }
}
