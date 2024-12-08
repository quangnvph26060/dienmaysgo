<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoOrder extends Model
{
    use HasFactory;
    protected $table = 'sgo_orders';

    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'country',
        'address',
        'postcode',
        'city',
        'phone',
        'email',
        'notes',
        'total_price',
        'payment_method',
        'status',
    ];
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function orderDetails()
    {
        return $this->hasMany(SgoOrderDetail::class, 'order_id');
    }
    public $timestamps = true;
}
