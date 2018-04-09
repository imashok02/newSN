<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
    $faker = Faker\Factory::create();

    for($i = 0; $i < 100; $i++) {
        App\User::create([
            'username' => $faker->userName,
            'name' => $faker->name,
            'password' =>bcrypt('password'),
            'email' => $faker->email
        ]);
    	}
	}
}
