<?php

namespace UserControlSkeleton;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\AdminController;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\AuthController;

class Routes
{
	protected $route;

	public function __construct()
	{
		$this->route = $_SERVER['REQUEST_URI'];
	}

	public function switchView()
	{
		if ($_POST && $this->route === '/') {
			(new AuthController)->login((new Requests));
		}

		if ($_POST && $this->route === '/Register') {
			(new UserController)->create((new Requests));
		}

		if ($_POST && $this->route === '/Account') {
			(new UserController)->update((new Requests));
		}

		if ($this->route === '/Logout') {
			(new AuthController)->logout();
		}

		if ((new UserController)->isLoggedIn() && (new AuthController)->isAdmin()) {
			(new GenerateView)->render('/AdminNavBar')->now();
		}

		if ((new UserController)->isLoggedIn() && !(new AuthController)->isAdmin()) {
			(new GenerateView)->render('/UserNavBar')->now();
		}

		if (!(new UserController)->isLoggedIn()) {
			(new GenerateView)->render('/GuestNavBar')->now();
		}

		if ($this->route === '/controlPanel' && (new AuthController)->isAdmin()) {
			(new GenerateView)->render($this->route)->now();
		}

		if ($this->route === '/controlPanel' && !(new AuthController)->isAdmin()) {
			(new GenerateView)->render('error', 'You are not authorized.');
		}

		if ($this->route === '/Account' && (new UserController)->isLoggedIn()) {
			(new GenerateView)->render($this->route, (new User)->getInfo())->now();
		}

		if ($this->route === '/Register' && !(new UserController)->isLoggedIn()) {
			(new GenerateView)->render($this->route)->now();
		}

		if ($this->route === '/') {
			(new GenerateView)->render($this->route)->now();
		}

		if ($_POST && $this->route === '/controlPanel') {
			(new GenerateView)
				->render('UserTable', (new AdminController)
				->searchUsers($_POST['search_field']))
				->now();
		}
	}
}
