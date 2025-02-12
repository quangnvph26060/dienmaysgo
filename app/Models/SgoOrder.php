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
        'fullname',
        'address',
        'phone',
        'email',
        'notes',
        'total_price',
        'payment_method',
        'status',
        'code',
        'reason',
        'payment_status',
        'deposit_amount',
        'user_id'
    ];
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function products()
    {
        return $this->belongsToMany(SgoProduct::class, 'order_product', 'order_id', 'product_id')->withPivot(['p_name', 'p_image', 'p_price', 'p_qty']);
    }

    public function transactionHistories()
    {
        return $this->hasMany(TransactionHistory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public $timestamps = true;
}
