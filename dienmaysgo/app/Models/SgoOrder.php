<?php

namespace App\Models;

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

    public $timestamps = true;
}
