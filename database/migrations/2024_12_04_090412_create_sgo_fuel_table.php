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
        Schema::create('sgo_fuel', function (Blueprint $table) {
            $table->id();  // Tạo khóa chính
            $table->string('name');  // Tên nhiên liệu
            $table->string('slug')->unique();  // Slug cho nhiên liệu
            $table->text('description')->nullable();  // Mô tả về nhiên liệu
            $table->timestamps();  // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_fuel');
    }
};
