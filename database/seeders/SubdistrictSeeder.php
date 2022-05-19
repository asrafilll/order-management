<?php

namespace Database\Seeders;

use App\Models\Subdistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment('testing')) {
            Subdistrict::truncate();
        }

        $json = File::get(storage_path('indonesia-areas/subdistricts.json'));
        $data = json_decode($json, true);
        $totalRows = count($data);
        $temp = [];

        foreach ($data as $index => $row) {
            $row['name'] = Str::upper($row['name']);
            $temp[] = $row;

            if (count($temp) > 50 || $index == $totalRows - 1) {
                Subdistrict::insert($temp);
                $temp = [];
            }
        }
    }
}
