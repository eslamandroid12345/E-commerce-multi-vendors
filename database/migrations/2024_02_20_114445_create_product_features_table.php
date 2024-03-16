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
         * جدول خصائص المنتجات
         */
        Schema::create('product_features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('الخاصيه التابعه للمنتج');
            $table->string('discrimination')->nullable()->comment('التمييز');
            $table->integer('quantity')->comment('الكمبه');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_features');
    }
};
