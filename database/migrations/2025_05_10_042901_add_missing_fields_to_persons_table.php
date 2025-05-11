<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            // فقط ستون‌هایی که هنوز تو جدول نیستن و خطا می‌گیری رو اضافه کن
            $table->string('first_name')->nullable()->after('type');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('nickname')->nullable()->after('last_name');
            $table->integer('credit_limit')->nullable()->after('nickname');
            $table->string('price_list')->nullable()->after('credit_limit');
            $table->string('tax_type')->nullable()->after('price_list');
            $table->string('national_code')->nullable()->after('tax_type');
            $table->string('economic_code')->nullable()->after('national_code');
            $table->string('registration_number')->nullable()->after('economic_code');
            $table->string('branch_code')->nullable()->after('registration_number');
            $table->text('description')->nullable()->after('branch_code');
            $table->text('address')->nullable()->after('description');
            $table->string('country')->nullable()->after('address');
            $table->unsignedBigInteger('province')->nullable()->after('country');
            $table->unsignedBigInteger('city')->nullable()->after('province');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('phone')->nullable()->after('postal_code');
            $table->string('mobile')->nullable()->after('phone');
            $table->string('fax')->nullable()->after('mobile');
            $table->string('phone1')->nullable()->after('fax');
            $table->string('phone2')->nullable()->after('phone1');
            $table->string('phone3')->nullable()->after('phone2');
            $table->string('email')->nullable()->after('phone3');
            $table->string('website')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('website');
            $table->date('marriage_date')->nullable()->after('birth_date');
            $table->date('join_date')->nullable()->after('marriage_date');
        });
    }

    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'nickname',
                'credit_limit',
                'price_list',
                'tax_type',
                'national_code',
                'economic_code',
                'registration_number',
                'branch_code',
                'description',
                'address',
                'country',
                'province',
                'city',
                'postal_code',
                'phone',
                'mobile',
                'fax',
                'phone1',
                'phone2',
                'phone3',
                'email',
                'website',
                'birth_date',
                'marriage_date',
                'join_date'
            ]);
        });
    }
};
