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
        Schema::create('sgo_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');  // Tham chiếu đến bảng sản phẩm
            $table->integer('quantity')->default(1);  // Số lượng sản phẩm
            $table->decimal('price', 10, 2);  // Giá sản phẩm
            $table->decimal('total_price', 10, 2);  // Tổng giá sản phẩm (quantity * price)
            $table->string('session_id')->nullable();  // ID phiên làm việc (nếu người dùng không đăng nhập)
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_cart');
    }
};
