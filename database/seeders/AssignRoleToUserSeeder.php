<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignRoleToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role */
        $role = Role::first();
        /** @var User */
        $user = User::first();
        $user->assignRole($role);
    }
}
