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
			$user->update($request);
		}

		if ($this->route === '/Logout') {
			$auth->logout();
		}

		if ($user->isLoggedIn() && $auth->isAdmin()) {
			GenerateView::render('/AdminNavBar');
		}

		if ($user->isLoggedIn() && !$auth->isAdmin()) {
			GenerateView::render('/UserNavBar');
		}

		if (!$user->isLoggedIn()) {
			GenerateView::render('/GuestNavBar');
		}

		if ($this->route === '/controlPanel' && $auth->isAdmin()) {
			GenerateView::render($this->route);
		}

		if ($this->route === '/controlPanel' && !$auth->isAdmin()) {
			GenerateViewWithMessage::render('error', 'You are not authorized.');
		}

		if ($this->route === '/Account' && $user->isLoggedIn()) {
			GenerateViewWithMessage::render($this->route, $user->getInfo());
		}

		if ($this->route === '/Register' && !$user->isLoggedIn()) {
			GenerateView::render($this->route);
		}

		if ($this->route === '/') {
			GenerateView::render($this->route);
		}

		if (isset($_POST['search_users'])) {
			GenerateViewWithMessage::render('UserTable', $admin->searchUsers($_POST['search_field']));
		}
	}
}
