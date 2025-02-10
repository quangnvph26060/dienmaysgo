<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'published',
        'description',
        'payment_percentage',
        'bank_code',
        'account_number'
    ];

    public  $casts = [
        'published' => 'boolean',
    ];
}
