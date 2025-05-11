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
        Schema::create('sellers', function (Blueprint $table) {
        $table->id();
        $table->string('seller_code')->unique();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('nickname')->nullable();
        $table->string('mobile')->nullable();
        $table->string('image')->nullable();
        $table->boolean('code_editable')->default(false); // سوییچ فعال/غیرفعال
        // بقیه فیلدها مثل شخص:
        $table->string('company_name')->nullable();
        $table->string('title')->nullable();
        $table->string('national_code')->nullable();
        $table->string('economic_code')->nullable();
        $table->string('registration_number')->nullable();
        $table->string('branch_code')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
