<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoNews extends Model
{
    use HasFactory;
    protected $table = 'sgo_news';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'published_at',
        'title_seo',
        'description_seo',
        'keyword_seo',
    ];

    public $timestamps = true;
}
