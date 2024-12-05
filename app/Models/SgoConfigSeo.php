<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SgoConfigSeo extends Model
{
    use HasFactory;
    protected $table = 'sgo_config_seo';

    // Các trường có thể được gán giá trị hàng loạt (mass assignable)
    protected $fillable = [
        'title_seo',
        'description_seo',
        'keywords_seo',
        'url',
    ];

    // Nếu bạn muốn sử dụng timestamp (created_at và updated_at), Laravel sẽ tự động thêm và cập nhật chúng
    public $timestamps = true;
}
