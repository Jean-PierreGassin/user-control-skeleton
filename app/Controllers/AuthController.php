<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Requests;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateViewWithMessage;

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
		$request = $request->data;

		if (empty($request['username']) || empty($request['password'])) {
			(new GenerateViewWithMessage)->render('error', 'All fields are required.');

			return;
		}

		$database = (new User)->getPassword($request['username']);

		if (!password_verify($request['password'], $database['password'])) {
			unset($_SESSION['logged_in']);
			unset($_SESSION['username']);

			(new GenerateViewWithMessage)->render('error', 'Incorrect login details.');

			return;
		}

		$_SESSION['logged_in'] = true;
		$_SESSION['username'] = $request['username'];

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
