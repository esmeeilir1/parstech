<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProvinceCitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('cities')->truncate();
        DB::table('provinces')->truncate();

        // استان خراسان رضوی و شهرهایش
        $khorasanId = DB::table('provinces')->insertGetId([
            'name' => 'خراسان رضوی',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('cities')->insert([
            [
                'name' => 'مشهد',
                'province_id' => $khorasanId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'نیشابور',
                'province_id' => $khorasanId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'سبزوار',
                'province_id' => $khorasanId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'جوین',
                'province_id' => $khorasanId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // استان تهران و شهرهایش
        $tehranId = DB::table('provinces')->insertGetId([
            'name' => 'تهران',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('cities')->insert([
            [
                'name' => 'تهران',
                'province_id' => $tehranId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'شهریار',
                'province_id' => $tehranId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'ورامین',
                'province_id' => $tehranId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // استان اصفهان و شهرهایش
        $esfahanId = DB::table('provinces')->insertGetId([
            'name' => 'اصفهان',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('cities')->insert([
            [
                'name' => 'اصفهان',
                'province_id' => $esfahanId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'کاشان',
                'province_id' => $esfahanId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'نجف آباد',
                'province_id' => $esfahanId,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
