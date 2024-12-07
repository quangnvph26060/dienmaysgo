<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeParent()
    {
        return $this->whereNull('category_parent_id')->with(['childrens', 'products.promotion'])->whereHas('products')->latest()->limit(3);
    }
}
