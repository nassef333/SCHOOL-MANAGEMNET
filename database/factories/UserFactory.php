<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->faker->numerify('###########'),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'role_id' => $this->faker->numberBetween(1, 2),
            'remember_token' => Str::random(10),
        ];
    }
}
