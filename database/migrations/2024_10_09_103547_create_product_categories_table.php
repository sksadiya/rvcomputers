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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); 
            $table->string('name'); 
            $table->unsignedBigInteger('parent_category_id')->nullable(); 
            $table->string('meta_title')->nullable(); 
            $table->text('meta_description')->nullable(); 
            $table->boolean('status')->default(true); 
            $table->timestamps();

            $table->foreign('parent_category_id')->references('id')->on('product_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
