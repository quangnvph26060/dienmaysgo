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
        Schema::create('sgo_news', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('title')->unique(); // Tiêu đề bài viết, không được trùng
            $table->longText('content'); // Nội dung chi tiết bài viết
            $table->string('image')->nullable(); // Đường dẫn ảnh bài viết
            $table->boolean('is_published')->default(false); // Trạng thái xuất bản
            $table->timestamp('published_at')->nullable(); // Ngày giờ xuất bản
            // Các trường SEO
            $table->string('title_seo')->nullable(); // Tiêu đề phục vụ SEO
            $table->text('description_seo')->nullable(); // Mô tả phục vụ SEO
            $table->string('keyword_seo')->nullable(); // Từ khóa SEO
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_news');
    }
};
