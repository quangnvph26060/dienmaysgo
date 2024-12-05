<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoOrigin extends Model
{
    use HasFactory;
    protected $table = 'sgo_origin';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public $timestamps = true;
}
