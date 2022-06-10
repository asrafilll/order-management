<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SyncSuperAdminRoleAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(AssignPermissionsToRoleSeeder::class);

        /** @var User */
        $user = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => 'secret',
            'email_verified_at' => Carbon::now(),
        ]);

        /** @var Role */
        $role = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $user->assignRole($role);
    }
}
