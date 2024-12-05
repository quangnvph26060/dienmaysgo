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
        Schema::create('sgo_orders', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->string('first_name'); // Tên
            $table->string('last_name'); // Họ
            $table->string('company_name')->nullable(); // Tên công ty (tùy chọn)
            $table->string('country'); // Quốc gia
            $table->string('address'); // Địa chỉ
            $table->string('postcode')->nullable();; // Mã bưu điện
            $table->string('city'); // Thành phố
            $table->string('phone'); // Số điện thoại
            $table->string('email'); // Địa chỉ email
            $table->text('notes')->nullable(); // Ghi chú (tùy chọn)
            $table->decimal('total_price', 10, 2); // Tổng giá trị đơn hàng
            $table->string('payment_method')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Trạng thái đơn hàng
            $table->timestamps(); // Timestamps cho created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_orders');
    }
};
