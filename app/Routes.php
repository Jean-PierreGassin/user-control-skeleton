<?php

namespace UserControlSkeleton;

use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\BaseController;

class Routes extends BaseController
{
    protected $route;

    protected $routeList;

    public function __construct()
    {
        parent::__construct();

        $this->route = $_SERVER['REQUEST_URI'];
        $this->routeList = $this->getRoutes();
    }

    public function switchView()
    {
        if (!in_array($this->route, array_keys($this->routeList))) {
            return header('location: /');
        }

        $view = new GenerateView();
        $route = $this->routeList[$this->route];
        $controller = new $route['controller'];

        // Check if user has access to this route
        if (in_array('admin', $route['access']) && !$this->auth->isAdmin()) {
            return header('location: /');
        }

        if (!in_array('guest', $route['access']) && !$this->auth->isLoggedIn()) {
            return header('location: /');
        }

        // Map our POST method to this route
        if ($_POST) {
            $postMethod = $route['postMethod'];
            $post = $controller->{$postMethod}(new Request);
        }

        // Define specific methods on GET
        if (isset($route['getMethod'])) {
            $getMethod = $route['getMethod'];
            $get = $controller->{$getMethod}(new Request);
        }

        // Display our navigation bar depending on user access
        if ($this->auth->isLoggedIn() && $this->auth->isAdmin()) {
            $view->render('/AdminNavBar')->now();

            return $view->render(...$route['render'])->now();
        }

        if ($this->auth->isLoggedIn()) {
            $view->render('/UserNavBar')->now();

            return $view->render(...$route['render'])->now();
        }

        if (!$this->auth->isLoggedIn()) {
            $view->render('/GuestNavBar')->now();

            return $view->render(...$route['render'])->now();
        }
    }

    public function getRoutes()
    {
        return [
            '/' => [
                    'controller' => 'UserControlSkeleton\Controllers\AuthController',
                    'postMethod' => 'login',
                    'render' => [$this->route],
                    'access' => ['guest', 'user'],
                ],
            '/Register' => [
                    'controller' => 'UserControlSkeleton\Controllers\UserController',
                    'postMethod' => 'create',
                    'render' => [$this->route],
                    'access' => ['guest', 'user'],
                ],
            '/Account' => [
                    'controller' => 'UserControlSkeleton\Controllers\UserController',
                    'postMethod' => 'update',
                    'render' => [$this->route, $this->user->getInfo()],
                    'access' => ['user'],
                ],
            '/Logout'=> [
                    'controller' => 'UserControlSkeleton\Controllers\AuthController',
                    'postMethod' => '',
                    'getMethod' => 'logout',
                    'render' => [$this->route],
                    'access' => ['user'],
                ],
            '/controlPanel' => [
                    'controller' => 'UserControlSkeleton\Controllers\AdminController',
                    'postMethod' => "searchUsers",
                    'render' => [$this->route, 'UserTable'],
                    'access' => ['admin'],
                ],
        ];
    }
}
