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

    protected $routeList;

    public function __construct()
    {
        $this->adapter = new MysqlAdapter();
        $this->user = new User($this->adapter);

        $this->route = $_SERVER['REQUEST_URI'];
        $this->routeList = $this->getRoutes();
    }

    public function switchView()
    {
        if (in_array($this->route, array_keys($this->routeList))) {
            $route = $this->routeList[$this->route];

            $view = new GenerateView();
            $user = new UserController($this->user);
            $auth = new AuthController($this->user);
            $controller = new $route['controller'](...$route['constructs']);

            // Check if user has access to this route
            if (in_array('admin', $route['access']) && !$auth->isAdmin()) {
                return header('location: /');
            }

            if (in_array('user', $route['access']) && !$user->isLoggedIn()) {
                return header('location: /');
            }

            // Map our post method to this route
            if ($_POST) {
                $postMethod = $route['postMethod'];
                $post = $controller->{$postMethod}(new Request);
            }

            // Display our navigation bar depending on user access
            if ($user->isLoggedIn() && $auth->isAdmin()) {
                $view->render('/AdminNavBar')->now();

                return $view->render(...$route['render'])->now();
            }

            if ($user->isLoggedIn()) {
                $view->render('/UserNavBar')->now();

                return $view->render(...$route['render'])->now();
            }

            if (!$user->isLoggedIn()) {
                $view->render('/GuestNavBar')->now();

                return $view->render(...$route['render'])->now();
            }
        }
    }

    public function getRoutes()
    {
        return [
            '/' => [
                    'controller' => 'UserControlSkeleton\Controllers\AuthController',
                    'constructs' => [$this->user],
                    'postMethod' => 'login',
                    'render' => [$this->route],
                    'access' => ['guest', 'user'],
                ],
            '/Register' => [
                    'controller' => 'UserControlSkeleton\Controllers\UserController',
                    'constructs' => [$this->user],
                    'postMethod' => 'create',
                    'render' => [$this->route],
                    'access' => ['guest', 'user'],
                ],
            '/Account' => [
                    'controller' => 'UserControlSkeleton\Controllers\UserController',
                    'constructs' => [$this->user],
                    'postMethod' => 'update',
                    'render' => [$this->route, $this->user->getInfo()],
                    'access' => ['user', 'admin'],
                ],
            '/Logout'=> [
                    'controller' => 'UserControlSkeleton\Controllers\AuthController',
                    'constructs' => [$this->user],
                    'postMethod' => '',
                    'render' => [$this->route],
                    'access' => ['user', 'admin'],
                ],
            '/controlPanel' => [
                    'controller' => 'UserControlSkeleton\Controllers\AdminController',
                    'constructs' => [$this->adapter, $this->user],
                    'postMethod' => "searchUsers",
                    'render' => [$this->route, 'UserTable'],
                    'access' => ['admin'],
                ],
        ];
    }
}
