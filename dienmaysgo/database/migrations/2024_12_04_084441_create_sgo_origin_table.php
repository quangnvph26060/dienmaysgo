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
        Schema::create('sgo_origin', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Tên xuất xứ (ví dụ: "Việt Nam", "Trung Quốc", "USA")
            $table->string('slug')->unique();  // Slug cho xuất xứ (dùng cho URL)
            $table->text('description')->nullable();  // Mô tả xuất xứ, có thể là lịch sử hoặc thông tin thêm
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_origin');
    }
};
