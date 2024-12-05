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
        Schema::create('sgo_config', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // Tên công ty
            $table->string('address'); // Địa chỉ
            $table->string('phone'); // Số điện thoại
            $table->string('email'); // Email (không trùng lặp)
            $table->string('tax_code')->nullable(); // Mã số thuế (có thể null)
            $table->string('link_fb')->nullable(); // Link Facebook
            $table->string('link_ig')->nullable(); // Link Instagram
            $table->string('zalo_number')->nullable(); // Số Zalo
            $table->string('path')->nullable(); // vd : © 2019-2024 - Bản quyền thuộc dienmaysgo.com
            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_config');
    }
};
