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
        'name' => 'Products',
        'icon' => 'fas fa-tag',
        'route_name' => 'products.index',
        'group_name' => 'products',
        'can' => PermissionEnum::manage_products()->value,
    ],
    [
        'name' => 'Employees',
        'icon' => 'fas fa-user-friends',
        'route_name' => 'employees.index',
        'group_name' => 'employees',
        'can' => PermissionEnum::manage_employees()->value,
    ],
    [
        'name' => 'Shippings',
        'icon' => 'fas fa-truck',
        'route_name' => 'shippings.index',
        'group_name' => 'shippings',
        'can' => PermissionEnum::manage_shippings()->value,
    ],
    [
        'name' => 'Order Source',
        'icon' => 'fas fa-cart-arrow-down',
        'route_name' => 'order-sources.index',
        'group_name' => 'order-sources',
        'can' => PermissionEnum::manage_order_sources()->value,
    ],
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
