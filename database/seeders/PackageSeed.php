<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Package;

class PackageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
        	['name' => 'Basic', 'duration_type' => 'months', 'duration_number' => 1, 'price' => 50000],
        	['name' => 'Middle', 'duration_type' => 'months', 'duration_number' => 3, 'price' => 130000],
        	['name' => 'Advance', 'duration_type' => 'months', 'duration_number' => 6, 'price' => 250000],
        ];

        foreach ($type as $key => $value) {
        	Package::create($value);
        }
    }
}
