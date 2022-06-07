<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->insert([
            'coupon_code' => "WTECH2021",
            'discount' => "15",
            'valid_until' => "2021/12/30"
        ]);

        DB::table('coupons')->insert([
            'coupon_code' => "WTECH2022",
            'discount' => "20%",
            'valid_until' => "2022/05/10"
        ]);

        DB::table('coupons')->insert([
            'coupon_code' => "WTECH2020",
            'discount' => "15%",
            'valid_until' => "2020/01/10"
        ]);
    }
}
