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
        'account_number',
        'account_details'
    ];

    public  $casts = [
        'published' => 'boolean',
        'account_details' => 'array',
    ];
}
