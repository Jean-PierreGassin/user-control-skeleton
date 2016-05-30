<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class AuthController
{
	protected $user;

	public function __construct()
	{
		$this->user = new User();
	}

	public function isAdmin()
	{
		$user = $this->user->isAdmin();

		if ($user['user_group'] != 2) {
			return;
		}

		return true;
	}

	public function login(RequestController $request)
	{
		$request = $request->data;

		if (empty($request['username']) || empty($request['password'])) {
			GenerateViewWithMessage::render('error', 'All fields are required.');

			return;
		}

		$database = $this->user->getPassword($request['username']);

		if (!password_verify($request['password'], $database['password'])) {
			unset($_SESSION['logged_in']);
			unset($_SESSION['username']);

			GenerateViewWithMessage::render('error', 'Incorrect login details.');

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
