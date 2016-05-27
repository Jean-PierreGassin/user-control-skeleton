<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\UserController;
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

		if ($this->route === '/Logout') {
			$user->logout();
		}

		if ($user->getLoginStatus() && $user->isAdmin()) {
			GenerateView::renderView('/AdminNavBar');
		}

		if ($user->getLoginStatus() && !$user->isAdmin()) {
			GenerateView::renderView('/UserNavBar');
		}

		if (!$user->getLoginStatus()) {
			GenerateView::renderView('/GuestNavBar');
		}

		if ($this->route === '/controlPanel' && $user->isAdmin()) {
			GenerateView::renderView($this->route);
		}

		if ($this->route === '/controlPanel' && !$user->isAdmin()) {
			GenerateViewWithMessage::renderView('error', 'You are not authorized.');
		}

		if ($this->route === '/Account' && $user->getLoginStatus()) {
			GenerateViewWithMessage::renderView($this->route, $user->getInfo());
		}

		if ($this->route === '/Register' && !$user->getLoginStatus()) {
			GenerateView::renderView($this->route);
		}

		if ($this->route === '/') {
			GenerateView::renderView($this->route);
		}

		if (isset($_POST['search_users'])) {
			GenerateViewWithMessage::renderView('UserTable', $user->searchUsers($_POST['search_field']), $user->getColumns());
		}
	}
}
