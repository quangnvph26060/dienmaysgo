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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Tạo cột 'id' tự động tăng
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // Tạo cột 'created_at' và 'updated_at'

            // Các trường bổ sung
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('google_id')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('token_expiry')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('role_id'); // Nếu có bảng 'roles' để quản lý role của người dùng
            $table->boolean('is_active')->default(1); // Trạng thái kích hoạt, mặc định là kích hoạt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
