<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Controllers\AdminController;

class BaseController
{
    protected $user;

    protected $auth;

    protected function __construct()
    {
        $this->user = new UserController();
        $this->auth = new AuthController();
    }
}
