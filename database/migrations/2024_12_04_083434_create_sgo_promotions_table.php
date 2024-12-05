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
        Schema::create('sgo_promotions', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('name');  // Name of the promotion
            $table->string('slug')->unique();  // Unique URL slug for the promotion
            $table->text('description')->nullable();  // Description of the promotion
            $table->decimal('discount', 8, 2);  // Discount amount or percentage
            $table->date('start_date')->nullable();  // Start date of the promotion
            $table->date('end_date')->nullable();  // End date of the promotion
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');  // Status of the promotion
            $table->timestamps();  // Created at, Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgo_promotions');
    }
};
