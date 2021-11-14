<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SpendLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $limits = [
            [
                'code' => 'DEMO_TIER',
                'price' => 0,
                'requests' => 20,
                'contacts' => 5,
            ],
            [
                'code' => 'TIER_1',
                'price' => 50000,
                'requests' => 1000,
                'contacts' => 100,
            ],
            [
                'code' => 'TIER_2',
                'price' => 100000,
                'requests' => 3000,
                'contacts' => 200,
            ],
            [
                'code' => 'TIER_3',
                'price' => 200000,
                'requests' => 10000,
                'contacts' => 1000,
            ]
        ];

        DB::table('spend_limits')->insert($limits);
    }
}
