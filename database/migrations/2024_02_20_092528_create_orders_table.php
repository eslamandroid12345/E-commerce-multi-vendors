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
         * جدول اوردرات العملاء
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('grand_total',10,2);
            $table->enum('payment_method',['cash','visa']);
            $table->string('payment_gateway')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('order_status',['pending','prepared','out_for_delivery','delivered'])->default('pending');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
