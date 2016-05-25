<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class RouteController
{
    public function getRoute()
    {
        $route = $_SERVER['REQUEST_URI'];

        return $this->route = $route;
    }

    public function switchView()
    {
        $user = new UserController;

		if (isset($_POST['login'])) {
            $user->login();
        }

        if (isset($_POST['register_user'])) {
            $user->create();
        }

        if (isset($_POST['update_user'])) {
            $user->updateUser();
        }

		if ($this->getRoute() === '/Logout') {
			session_destroy();
			header("Location: ../index.php");
		}

        if ($user->getLoginStatus() && $user->isAdmin()) {
            GenerateView::renderView('/AdminNavBar');
        } else if ($user->getLoginStatus()) {
            GenerateView::renderView('/UserNavBar');
        } else {
            GenerateView::renderView('/GuestNavBar');
        }

        if ($this->getRoute() == '/controlPanel' && !$user->isAdmin()) {
            GenerateViewWithMessage::renderView('error', 'You are not authorized.');
        } else if ($this->getRoute() == '/Account' && $user->getLoginStatus()) {
            GenerateViewWithMessage::renderView($this->getRoute(), $user->getInfo());
        } else {
            GenerateView::renderView($this->getRoute());
        }

        if (isset($_POST['search_users'])) {
            GenerateViewWithMessage::renderView('UserTable', $user->searchUsers($_POST['search_field']), $user->getColumns());
        }
    }
}
