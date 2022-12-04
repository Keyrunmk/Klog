<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    protected $countries = [
        ["country_name" => "World"],
        ["country_name" => "Nepal"],
        ["country_name" => "India"],
        ["country_name" => "China"],
        ["country_name" => "Canada"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::insert($this->countries);
    }
}
