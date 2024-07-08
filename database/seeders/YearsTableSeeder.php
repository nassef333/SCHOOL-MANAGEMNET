<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class YearsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('years')->insert([
            ['name' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
