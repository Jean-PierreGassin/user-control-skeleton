<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Requests;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;

class AuthController
{
	public function isAdmin()
	{
		$user = (new User)->isAdmin();

		if ($user['user_group'] != 2) {
			return;
		}

		return true;
	}

	public function login(Requests $request)
	{
		if (!$request->get('username') || !$request->get('password')) {
			$view->render('error', 'All fields are required');

			return;
		}

		$view = new GenerateView();
		$username = $request->get('username');
		$password = $request->get('password');

		if (!password_verify($password, (new User)->getPassword($request->get('username')))) {
			unset($_SESSION['logged_in']);
			unset($_SESSION['username']);

			$view->render('error', 'Incorrect login details');

			return;
		}

		$_SESSION['logged_in'] = true;
		$_SESSION['username'] = $username;

		header("Location: ../Account");
	}

	public function logout()
	{
		unset($_SESSION['logged_in']);
		unset($_SESSION['username']);

		session_destroy();
		header("Location: ../");
	}
}
