<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // seeders for default admin user account
        DB::table('users')->insert([
            'name' => $faker->name,
            'email' => $faker->email,
            'username' => $faker->userName,
            'password' => Hash::make('password'),
        ]);

        // php artisan db:seed --class=UserSeeder
    }

}
