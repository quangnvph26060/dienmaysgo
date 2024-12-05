<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sgo_products', function (Blueprint $table) {
            $table->id();  // Khóa chính
            $table->string('name');  // Tên sản phẩm
            $table->string('slug')->unique();  // Slug của sản phẩm
            $table->decimal('price', 10, 2)->nullable();  // Giá sản phẩm
            $table->integer('quantity');  // Số lượng sản phẩm
            $table->integer('category_id')->nullable();  // Khóa ngoại với bảng danh mục
            $table->text('description_short')->nullable();  // Mô tả ngắn về sản phẩm
            $table->text('description')->nullable();  // Mô tả chi tiết sản phẩm
            $table->integer('promotions_id')->nullable();  // Khóa ngoại với bảng khuyến mãi
            $table->integer('origin_id')->nullable();  // Khóa ngoại với bảng xuất xứ
            $table->integer('fuel_id')->nullable();  // Khóa ngoại với bảng nhiên liệu
            $table->string('title_seo')->nullable();  // Tiêu đề SEO
            $table->string('description_seo')->nullable();  // Mô tả SEO
            $table->string('keyword_seo')->nullable();  // Từ khóa SEO
            $table->timestamps();  // Thời gian tạo và cập nhật
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_products');
    }
};
