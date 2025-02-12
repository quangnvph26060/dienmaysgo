<?php

use App\Models\SgoOrder;
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
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->on('sgo_orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->on('sgo_products')->cascadeOnDelete();

            $table->string('p_name');
            $table->string('p_image');
            $table->decimal('p_price');
            $table->unsignedBigInteger('p_qty');

            $table->primary(['product_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
