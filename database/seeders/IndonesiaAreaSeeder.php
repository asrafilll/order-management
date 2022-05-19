<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IndonesiaAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SubdistrictSeeder::class);
        $this->call(VillageSeeder::class);
    }
}
