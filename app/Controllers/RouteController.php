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
		if (isset($_POST['login'])) {
			(new AuthController)->login((new RequestController));
		}

		if (isset($_POST['register_user'])) {
			(new UserController)->create((new RequestController));
		}

		if (isset($_POST['update_user'])) {
			(new UserController)->update((new RequestController));
		}

		if ($this->route === '/Logout') {
			(new AuthController)->logout();
		}

		if ((new UserController)->isLoggedIn() && (new AuthController)->isAdmin()) {
			GenerateView::render('/AdminNavBar');
		}

		if ((new UserController)->isLoggedIn() && !(new AuthController)->isAdmin()) {
			GenerateView::render('/UserNavBar');
		}

		if (!(new UserController)->isLoggedIn()) {
			GenerateView::render('/GuestNavBar');
		}

		if ($this->route === '/controlPanel' && (new AuthController)->isAdmin()) {
			GenerateView::render($this->route);
		}

		if ($this->route === '/controlPanel' && !(new AuthController)->isAdmin()) {
			GenerateViewWithMessage::render('error', 'You are not authorized.');
		}

		if ($this->route === '/Account' && (new UserController)->isLoggedIn()) {
			GenerateViewWithMessage::render($this->route, (new UserController)->getInfo());
		}

		if ($this->route === '/Register' && !(new UserController)->isLoggedIn()) {
			GenerateView::render($this->route);
		}

		if ($this->route === '/') {
			GenerateView::render($this->route);
		}

		if (isset($_POST['search_users'])) {
			GenerateViewWithMessage::render('UserTable', (new AdminController)->searchUsers($_POST['search_field']));
		}
	}
}
