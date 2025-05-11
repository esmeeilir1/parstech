<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // اگر این ستون‌ها را نداری اضافه کن
            if (!Schema::hasColumn('products', 'weight')) $table->integer('weight')->nullable();
            if (!Schema::hasColumn('products', 'buy_price')) $table->bigInteger('buy_price')->nullable();
            if (!Schema::hasColumn('products', 'sell_price')) $table->bigInteger('sell_price')->nullable();
            if (!Schema::hasColumn('products', 'discount')) $table->integer('discount')->nullable();
            if (!Schema::hasColumn('products', 'store_barcode')) $table->string('store_barcode', 100)->nullable();
            if (!Schema::hasColumn('products', 'gallery')) $table->text('gallery')->nullable();
            if (!Schema::hasColumn('products', 'video')) $table->string('video', 255)->nullable();
            if (!Schema::hasColumn('products', 'attributes')) $table->text('attributes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'weight', 'buy_price', 'sell_price', 'discount', 'store_barcode', 'gallery', 'video', 'attributes'
            ]);
        });
    }
}
