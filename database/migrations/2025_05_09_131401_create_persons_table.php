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
            Schema::create('persons', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('accounting_code')->unique();
                // بقیه فیلدهای مورد نیازت را اضافه کن (first_name, last_name و ...)
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
