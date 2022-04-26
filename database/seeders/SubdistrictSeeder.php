<?php

namespace Database\Seeders;

use App\Models\Subdistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new \ParseCsv\Csv(
            storage_path('indonesia-areas/subdistricts.csv')
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
                Subdistrict::insert($temp);
                $temp = [];
            }
        }
    }
}
