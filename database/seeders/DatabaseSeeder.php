<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SubjectsTableSeeder::class,
            TrainingsTableSeeder::class,
            UsersTableSeeder::class,
            YearsTableSeeder::class,
            BranchesTableSeeder::class,
            RatingsTableSeeder::class,
        ]);
    }
}
