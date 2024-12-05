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
        Schema::create('sgo_orders_detail', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->foreignId('order_id')->constrained('sgo_orders')->onDelete('cascade'); // Khóa ngoại liên kết với bảng sgo_orders
            $table->string('product_name'); // Tên sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->timestamps(); // Timestamps cho created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_orders_detail');
    }
};
