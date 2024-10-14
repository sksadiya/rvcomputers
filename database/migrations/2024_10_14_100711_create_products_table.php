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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('brand_id')->nullable(); 
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->string('unit')->nullable();
            $table->decimal('weight', 8, 2)->nullable()->default(0.00);
            $table->integer('min_qty')->default(1);
            $table->string('video_provider')->nullable();
            $table->string('video_link')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable()->default(0);
            $table->string('discount_type')->nullable()->default('percentage'); // e.g., percentage or flat
            $table->integer('current_stock')->default(0);
            $table->string('sku')->unique()->nullable(); // Set SKU as unique and not nullable
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('low_stock_quantity')->default(5);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
