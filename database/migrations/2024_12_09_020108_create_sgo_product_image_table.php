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
        Schema::create('sgo_product_image', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự tăng
            $table->unsignedBigInteger('product_id'); // Liên kết với sản phẩm
            $table->string('image'); // Đường dẫn hình ảnh
            $table->timestamps(); // Tạo cột created_at và updated_at

            // Đặt khóa ngoại
            $table->foreign('product_id')
                  ->references('id')
                  ->on('sgo_products')
                  ->onDelete('cascade'); // Xóa sản phẩm sẽ xóa ảnh liên quan
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_product_image');
    }
};
