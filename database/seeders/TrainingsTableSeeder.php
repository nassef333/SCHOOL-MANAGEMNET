<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trainings')->insert([
            ['name' => 'Classroom Management', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Effective Teaching', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Curriculum Development', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
