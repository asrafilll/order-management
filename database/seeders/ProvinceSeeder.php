<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new \ParseCsv\Csv(
            storage_path('indonesia-areas/provinces.csv')
        );

        $totalRows = count($csv->data);

        Schema::disableForeignKeyConstraints();
        Province::truncate();

        $temp = [];

        foreach ($csv->data as $index => $row) {
            $temp[] = [
                'code' => $row['Code'],
                'name' => $row['Name'],
            ];

            if (count($temp) > 50 || $index == $totalRows - 1) {
                Province::insert($temp);
                $temp = [];
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
