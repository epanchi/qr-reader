<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        DB::table("users")->insert([
            "name" => $faker->name(),
            "email" => 'demo@mail.com',
            "email_verified_at" => now(),
            "password" => bcrypt('0987654321'),
            "created_at" => now(),
            "updated_at" => now(),
        ]);

    }
}
