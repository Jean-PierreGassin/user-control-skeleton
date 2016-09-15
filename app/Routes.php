<?php

namespace UserControlSkeleton;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Controllers\AdminController;
use UserControlSkeleton\Models\Database\MysqlAdapter;

class Routes
{
    protected $route;

    protected $user;

    protected $adapter;

    public function __construct()
    {
        $this->adapter = new MysqlAdapter();
        $this->user = new User($this->adapter);
        $this->route = $_SERVER['REQUEST_URI'];
    }

    public function switchView()
    {
        if ($_POST && $this->route === '/') {
            (new AuthController($this->user))->login(new Request);
        }

        if ($_POST && $this->route === '/Register') {
            (new UserController($this->user))->create(new Request);
        }

        if ($_POST && $this->route === '/Account') {
            (new UserController($this->user))->update(new Request);
        }

        if ($this->route === '/Logout') {
            (new AuthController($this->user))->logout();
        }

        if ((new UserController($this->user))->isLoggedIn() && (new AuthController($this->user))->isAdmin()) {
            (new GenerateView)->render('/AdminNavBar')->now();
        }

        if ((new UserController($this->user))->isLoggedIn() && !(new AuthController($this->user))->isAdmin()) {
            (new GenerateView)->render('/UserNavBar')->now();
        }

        if (!(new UserController($this->user))->isLoggedIn()) {
            (new GenerateView)->render('/GuestNavBar')->now();
        }

        if ($this->route === '/controlPanel' && (new AuthController($this->user))->isAdmin()) {
            (new GenerateView)->render($this->route)->now();
        }

        if ($this->route === '/controlPanel' && !(new AuthController($this->user))->isAdmin()) {
            (new GenerateView)->render('error', 'You are not authorized.');
        }

        if ($this->route === '/Account' && (new UserController($this->user))->isLoggedIn()) {
            (new GenerateView)->render($this->route, $this->user->getInfo())->now();
        }

        if ($this->route === '/Register' && !(new UserController($this->user))->isLoggedIn()) {
            (new GenerateView)->render($this->route)->now();
        }

        if ($this->route === '/') {
            (new GenerateView)->render($this->route)->now();
        }

        if ($_POST && $this->route === '/controlPanel') {
            (new GenerateView)
            ->render('UserTable', (new AdminController($this->adapter, $this->user))
            ->searchUsers($_POST['search_field']))
            ->now();
        }
    }
}
