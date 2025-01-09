<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SgoConfig extends Model
{
    use HasFactory;
    protected $table = 'sgo_config';
    protected $fillable = [
        'company_name',
        'address',
        'warehouse',
        'phone',
        'email',
        'tax_code',
        'link_fb',
        'link_ig',
        'zalo_number',
        'path',
        'title_seo',
        'description_seo',
        'keywords_seo',
        'content',
        'introduct_title',
        'introduction',
        'icon'
    ];

    protected $casts = [
        'introduction' => 'array',
    ];

    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('site_settings');
        });
    }
}
