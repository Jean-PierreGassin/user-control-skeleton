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
        $this->routeList = $this->app->config('routes');
        $this->view = new GenerateView();
    }

    public function switchView()
    {
        if (!in_array($this->route, array_keys($this->routeList))) {
            return header('location: /');
        }

        $route = $this->routeList[$this->route];
        $controller = new $route['controller'];

        // Check if user has access to this route
        if (!$this->userHasAccess($route)) {
            return header('location: /');
        }

        // Map our POST method to this route
        if ($_POST) {
            $postMethod = $route['postMethod'];
            $methodResult = $controller->{$postMethod}(new Request);
        }

        // Define specific methods on GET
        if (isset($route['getMethod'])) {
            $getMethod = $route['getMethod'];
            $methodResult = $controller->{$getMethod}(new Request);
        }

        $this->view->render($this->route, $methodResult);
    }

    public function userHasAccess($route)
    {
        if (in_array('admin', $route['access']) && !$this->auth->isAdmin()) {
            return;
        }

        if (!in_array('guest', $route['access']) && !$this->auth->isLoggedIn()) {
            return;
        }

        return true;
    }
}
