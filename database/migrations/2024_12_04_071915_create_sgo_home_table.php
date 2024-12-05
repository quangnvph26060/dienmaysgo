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
        Schema::create('sgo_home', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->string('name')->unique(); // Tên, không được trùng
            $table->string('slug'); // Slug, không được trùng
            $table->longText('content')->nullable(); // Nội dung
            // Các trường SEO
            $table->string('title_seo')->nullable(); // Tiêu đề phục vụ SEO
            $table->text('description_seo')->nullable(); // Mô tả phục vụ SEO
            $table->string('keyword_seo')->nullable(); // Từ khóa phục vụ SEO
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_home');
    }
};
