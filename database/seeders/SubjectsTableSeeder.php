<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            ['name' => 'Math', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Science', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'History', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Geography', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
