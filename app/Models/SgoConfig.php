<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoConfig extends Model
{
    use HasFactory;
    protected $table = 'sgo_config';
    protected $fillable = [
        'company_name',
        'address',
        'phone',
        'email',
        'tax_code',
        'link_fb',
        'link_ig',
        'zalo_number',
        'path'
    ];

    public $timestamps = true;
}
