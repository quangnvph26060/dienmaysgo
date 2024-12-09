<?php

namespace App\Models;

use App\Models\SgoProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoProductImages extends Model
{
    use HasFactory;
    protected $table = 'sgo_product_image';

    protected $fillable = [
        'product_id',
        'image',
    ];

    public $timestamps = true;

    public function product()
{
    return $this->belongsTo(SgoProduct::class, 'product_id');
}
}
