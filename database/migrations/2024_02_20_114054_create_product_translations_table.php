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

        /*
         * جدول ترجمه بيانات المنتجات
         */
        Schema::create('product_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
