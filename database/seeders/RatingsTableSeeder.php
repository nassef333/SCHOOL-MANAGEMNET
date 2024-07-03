<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ratings')->insert([
            [
                'supervisor_id' => 1,
                'teacher_id' => 2,
                'molars_and_skills' => 8,
                'homework' => 7,
                'planning' => 9,
                'media_usage' => 6,
                'learning_strategy' => 8,
                'manage_class' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
