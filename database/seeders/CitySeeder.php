<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new \ParseCsv\Csv(
            storage_path('indonesia-areas/cities.csv')
        );

        $totalRows = count($csv->data);
        $temp = [];

        foreach ($csv->data as $index => $row) {
            $temp[] = [
                'code' => $row['Code'],
                'parent' => $row['Parent'],
                'name' => $row['Name'],
            ];

            if (count($temp) > 50 || $index == $totalRows - 1) {
                City::insert($temp);
                $temp = [];
            }
        }
    }
}
