<?php

/**
 * Menu list which show on sidebar
 * Available properties:
 * - name : Menu name.
 * - icon : Font awesome class name. eg: fas fa-users
 * - route_name : Route name.
 * - group_name : Group name for set active class. Use route prefix name. eg: users
 * - can : Permission for access this menu
 */

use App\Enums\PermissionEnum;

return [
    [
        'name' => 'Users',
        'icon' => 'fas fa-users',
        'route_name' => 'users.index',
        'group_name' => 'users',
        'can' => PermissionEnum::manage_users_and_roles()->value,
    ],
    [
        'name' => 'Roles',
        'icon' => 'fas fa-user-lock',
        'route_name' => 'roles.index',
        'group_name' => 'roles',
        'can' => PermissionEnum::manage_users_and_roles()->value,
    ],
];
