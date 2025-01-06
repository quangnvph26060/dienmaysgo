<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SgoCategory extends Model
{
    use HasFactory;
    protected $table = 'sgo_category';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'description_short',
        'logo',
        'category_parent_id',
        'title_seo',
        'description_seo',
        'keyword_seo'
    ];

    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::tags('categories')->flush();
        });

        static::deleted(function () {
            Cache::tags('categories')->flush();
        });
    }

    // Nếu muốn tạo mối quan hệ cha-con trong bảng chính
    public function parent()
    {
        return $this->belongsTo(SgoCategory::class, 'category_parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(SgoCategory::class, 'category_parent_id');
    }

    public function products()
    {
        return $this->hasMany(SgoProduct::class, 'category_id');
    }

    public function scopeParent($query)
    {
        // return $this->whereNull('category_parent_id')->with(['childrens', 'products.promotion'])->whereHas('products')->latest()->limit(3);
        return $query->whereNull('category_parent_id') // Chỉ lấy các danh mục cha
            ->with(['childrens.products.promotion']);
    }

    public function allChildrenIds()
    {
        return $this->childrens->reduce(function ($carry, $child) {
            return $carry->merge([$child->id])->merge($child->allChildrenIds());
        }, collect());
    }
}
