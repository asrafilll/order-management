<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AssignPermissionsToRoleSeeder::class);
        $this->call(AssignRoleToUserSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SubdistrictSeeder::class);
        $this->call(VillageSeeder::class);
    }
}
