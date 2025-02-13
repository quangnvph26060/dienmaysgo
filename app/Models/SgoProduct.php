<?php

namespace App\Models;

use App\Models\SgoCategory;
use App\Models\SgoFuel;
use App\Models\SgoOrigin;
use App\Models\SgoPromotion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SgoProduct extends Model
{
    use HasFactory;
    protected $table = 'sgo_products';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'quantity',
        'category_id',
        'description_short',
        'description',
        'promotions_id',
        'origin_id',
        'fuel_id',
        'title_seo',
        'description_seo',
        'keyword_seo',
        'image',
        'import_price',
        'tags',
        'discount_type',
        'discount_value',
        'discount_end_date',
        'discount_start_date',
        'brand_id',
        'module'
    ];


    public $timestamps = true;
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->isDirty('name')) $model->slug = Str::slug($model->name);
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) $model->slug = Str::slug($model->name);
        });

        static::saved(function () {
            Cache::forget('home_data');
            Cache::forget('categories');
        });
    }
    public function category()
    {
        return $this->belongsTo(SgoCategory::class, 'category_id');
    }

    public function promotion()
    {
        return $this->belongsTo(SgoPromotion::class, 'promotions_id');
    }

    // public function origin()
    // {
    //     return $this->belongsTo(SgoOrigin::class, 'origin_id');
    // }

    // public function fuel()
    // {
    //     return $this->belongsTo(SgoFuel::class, 'fuel_id');
    // }

    public function images()
    {
        return $this->hasMany(SgoProductImages::class, 'product_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values', 'sgo_product_id', 'attribute_id')
            ->withPivot('attribute_value_id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'sgo_product_id', 'attribute_value_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    protected $casts = [
        'discount_end_date' => 'datetime',
        'discount_start_date ' => 'datetime',
    ];
}
