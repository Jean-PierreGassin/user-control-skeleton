<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Controllers\AdminController;

class BaseController
{
    protected $app;

    protected $user;

    protected $auth;

    public function __construct()
    {
        $this->app = $this;

        $this->user = new UserController();
        $this->auth = new AuthController();
    }

    public function config($type = null)
    {
        $config = require __DIR__."/../config/app.php";

        return $config[$type];
    }
}
