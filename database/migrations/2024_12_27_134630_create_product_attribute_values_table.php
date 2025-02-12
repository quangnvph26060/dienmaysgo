<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\SgoProduct;
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
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->foreignIdFor(SgoProduct::class)->constrained();
            $table->foreignIdFor(Attribute::class)->constrained();
            $table->foreignIdFor(AttributeValue::class)->constrained();
            $table->timestamps();
            
            $table->unique(['product_id', 'attribute_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};
