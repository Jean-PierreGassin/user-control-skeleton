<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class RouteController
{
	protected $route;

	public function __construct()
	{
		$this->route = $_SERVER['REQUEST_URI'];
	}

	public function switchView()
	{
		$user = new UserController();
		$auth = new AuthController();
		$admin = new AdminController();
		$request = new RequestController();

		if (isset($_POST['login'])) {
			$auth->login($request);
		}

		if (isset($_POST['register_user'])) {
			$user->create($request);
		}

		if (isset($_POST['update_user'])) {
			$user->updateUser($request);
		}

		if ($this->route === '/Logout') {
			$auth->logout();
		}

		if ($auth->getLoginStatus() && $auth->isAdmin()) {
			GenerateView::renderView('/AdminNavBar');
		}

		if ($auth->getLoginStatus() && !$auth->isAdmin()) {
			GenerateView::renderView('/UserNavBar');
		}

		if (!$auth->getLoginStatus()) {
			GenerateView::renderView('/GuestNavBar');
		}

		if ($this->route === '/controlPanel' && $auth->isAdmin()) {
			GenerateView::renderView($this->route);
		}

		if ($this->route === '/controlPanel' && !$auth->isAdmin()) {
			GenerateViewWithMessage::renderView('error', 'You are not authorized.');
		}

		if ($this->route === '/Account' && $auth->getLoginStatus()) {
			GenerateViewWithMessage::renderView($this->route, $user->getInfo());
		}

		if ($this->route === '/Register' && !$auth->getLoginStatus()) {
			GenerateView::renderView($this->route);
		}

		if ($this->route === '/') {
			GenerateView::renderView($this->route);
		}

		if (isset($_POST['search_users'])) {
			GenerateViewWithMessage::renderView('UserTable', $admin->searchUsers($_POST['search_field']), $admin->getColumns());
		}
	}
}
