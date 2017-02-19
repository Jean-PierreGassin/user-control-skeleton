<?php

/*
 * This file is used to configure generic application variables
 */
return [
    'timezone' => date_default_timezone_set('Australia/Brisbane'),

    'routes' => [
        '/' => [
                'controller' => 'UserControlSkeleton\Controllers\AuthController',
                'postMethod' => 'login',
                'access' => ['guest', 'user'],
            ],
        '/Register' => [
                'controller' => 'UserControlSkeleton\Controllers\UserController',
                'postMethod' => 'create',
                'access' => ['guest', 'user'],
            ],
        '/Account' => [
                'controller' => 'UserControlSkeleton\Controllers\UserController',
                'postMethod' => 'update',
                'getMethod' => 'getInfo',
                'access' => ['user'],
            ],
        '/Logout'=> [
                'controller' => 'UserControlSkeleton\Controllers\AuthController',
                'postMethod' => '',
                'getMethod' => 'logout',
                'access' => ['user'],
            ],
        '/controlPanel' => [
                'controller' => 'UserControlSkeleton\Controllers\AdminController',
                'postMethod' => 'searchUsers',
                'access' => ['admin'],
            ],
    ],
];
