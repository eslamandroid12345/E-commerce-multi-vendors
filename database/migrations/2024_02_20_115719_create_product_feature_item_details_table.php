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
         * جدول اضافه سعر معين لخاصيه معينه
         */
        Schema::create('product_feature_item_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_feature_item_id')->comment('سعر المنتج');
            $table->unsignedBigInteger('product_feature_detail_id')->comment('انهي خاصيه');
            $table->timestamps();
            $table->foreign('product_feature_item_id')->references('id')->on('product_feature_items')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('product_feature_detail_id')->references('id')->on('product_feature_details')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_feature_item_details');
    }
};
