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
         * جدول المشرفين والبائعين
         */
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('image')->nullable();
            $table->string('name');
            $table->string('store_name')->comment('اسم المتجر للبائع')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->comment('تسجيل الهاتف في حاله نوع المستخدم بائع')->nullable()->unique();
            $table->enum('user_type',['admin','seller'])->default('seller');
            $table->boolean('is_active')->default(1);
            $table->longText('access_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
