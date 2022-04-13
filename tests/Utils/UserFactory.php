<?php

namespace Tests\Utils;

use App\Enums\PermissionEnum;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Contracts\Auth\Authenticatable;

trait UserFactory
{
    public function createUserWithPermission(PermissionEnum $permissionEnum): User|Authenticatable
    {
        $this->seed(PermissionSeeder::class);

        /** @var User */
        $user = User::factory()->create();
        $user->givePermissionTo($permissionEnum->value);

        return $user;
    }

    public function createUser(): User|Authenticatable
    {
        return User::factory()->create();
    }
}
