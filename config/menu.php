<?php

/**
 * Menu list which show on sidebar
 * Available properties:
 * - name : Menu name.
 * - icon : Font awesome class name. eg: fas fa-users
 * - route_name : Route name.
 * - group_name : Group name for set active class. Use route prefix name. eg: users
 */

return [
    [
        'name' => 'Users Management',
        'icon' => 'fas fa-users',
        'route_name' => 'users.index',
        'group_name' => 'users',
    ],
];
