<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoHome extends Model
{
    use HasFactory;
    protected $table = 'sgo_home';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'title_seo',
        'description_seo',
        'keyword_seo',
    ];

    public $timestamps = true;
}
