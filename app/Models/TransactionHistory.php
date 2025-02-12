<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = ['sgo_order_id', 'transaction_amount', 'transaction_date', 'transaction_status', 'transaction_notes'];

    // Mối quan hệ với bảng orders
    public function order()
    {
        return $this->belongsTo(SgoOrder::class, 'sgo_order_id');
    }
}
