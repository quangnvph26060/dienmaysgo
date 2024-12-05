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
        Schema::create('sgo_config_seo', function (Blueprint $table) {
            $table->id();
            $table->string('title_seo')->nullable(); // Tiêu đề SEO
            $table->text('description_seo')->nullable(); // Mô tả SEO
            $table->text('keywords_seo')->nullable(); // Từ khóa SEO
            $table->string('url')->nullable(); // URL (có thể là đường dẫn của trang)
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_config_seo');
    }
};
