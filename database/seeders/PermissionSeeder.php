<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $temp = [];
        $permissions = Config::get('app.permissions');
        $lastIndex = count($permissions) - 1;

        foreach ($permissions as $index => $permission) {
            $temp[] = [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($temp) >= 50 || $index == $lastIndex) {
                Permission::insert($temp);
            }
        }
    }
}
