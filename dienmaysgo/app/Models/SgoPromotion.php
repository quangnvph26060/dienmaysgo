<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoPromotion extends Model
{
    use HasFactory;
    protected $table = 'sgo_promotions';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'discount',
        'start_date',
        'end_date',
        'status',
    ];

    public $timestamps = true;
}
