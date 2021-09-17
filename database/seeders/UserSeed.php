<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Str;
use \Carbon\Carbon;
class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = \Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
        	$user = User::create([
	        	'name' => $faker->name(),
				'email' => $faker->unique()->safeEmail(),
	        	'no_hp' => $faker->phoneNumber(),
				'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
				'remember_token' => Str::random(10),	
        	]);
        	$dueDate = new Carbon('+3 months');
        	$lastBuy = new Carbon('now');
        	$user->userPackages()->create([
        		'package_id' => 2,
        		'due_date' => $dueDate->toDateString(),
        		'last_buy' => $lastBuy->toDateString(),
        		'status' => '1'
        	]);
        }
    }
}
