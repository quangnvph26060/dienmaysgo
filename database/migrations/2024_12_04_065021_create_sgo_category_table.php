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
        Schema::create('sgo_category', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('name')->unique(); // Tên danh mục
            $table->string('slug'); // Slug, unique để không trùng lặp
            $table->text('description')->nullable(); // Mô tả, cho phép null
            $table->string('logo')->nullable(); // Đường dẫn logo, cho phép null
            $table->unsignedBigInteger('category_parent_id')->nullable(); // ID danh mục cha
            $table->string('title_seo')->nullable(); // Tiêu đề SEO
            $table->text('description_seo')->nullable(); // Mô tả SEO
            $table->string('keyword_seo')->nullable(); // Từ khóa SEO
            $table->foreign('category_parent_id')->references('id')->on('sgo_category')->onDelete('cascade'); // Khóa ngoại tới chính nó
            $table->timestamps(); // Tạo trường created_at và updated_at tự động
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_category');
    }
};
