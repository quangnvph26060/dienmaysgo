<?php

namespace App\Models;

use App\Models\SgoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'sgo_orders_detail';
    protected $fillable = [
        'order_id',
        'product_name',
        'price',
        'quantity',
    ];

    public $timestamps = true;

    public function order()
    {
        return $this->belongsTo(SgoOrder::class, 'order_id');
    }
}
