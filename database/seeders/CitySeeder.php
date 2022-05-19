<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment('testing')) {
            City::truncate();
        }

        $json = File::get(storage_path('indonesia-areas/cities.json'));
        $data = json_decode($json, true);
        $totalRows = count($data);
        $temp = [];

        foreach ($data as $index => $row) {
            $temp[] = $row;

            if (count($temp) > 50 || $index == $totalRows - 1) {
                City::insert($temp);
                $temp = [];
            }
        }
    }
}
