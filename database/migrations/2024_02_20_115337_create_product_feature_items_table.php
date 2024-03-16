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
         * جدول اسعار المنتجات
         */
        Schema::create('product_feature_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->double('product_price',10,2)->default(0.00)->comment('سعر المنتح الاصلي');
            $table->double('price',10,2)->default(0.00)->comment('سعر المنتج');
            $table->double('discount',10,2)->default(0.00)->comment('قيمه الخصم');
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_feature_items');
    }
};
