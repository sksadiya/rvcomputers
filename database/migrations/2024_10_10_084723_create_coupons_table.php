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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('promocode')->unique(); 
            $table->decimal('percentage', 5, 2); 
            $table->decimal('minimum_amount', 10, 2); 
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->integer('max_uses_per_user')->default(1); 
            $table->text('description')->nullable(); 
            $table->text('terms_and_conditions')->nullable(); 
            $table->string('logo')->nullable(); 
            $table->boolean('status')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
