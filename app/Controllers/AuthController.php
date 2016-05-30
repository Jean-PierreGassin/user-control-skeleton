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

	public function login(RequestController $request)
	{
		if (empty($request->data['username']) || empty($request->data['password'])) {
			GenerateViewWithMessage::renderView('error', 'All fields are required.');

			return;
		}

		$database = $this->user->getPassword($request->data['username']);

		if (!password_verify($request->data['password'], $database['password'])) {
			unset($_SESSION['logged_in']);
			unset($_SESSION['username']);

			GenerateViewWithMessage::renderView('error', 'Incorrect login details.');

			return;
		}

		$_SESSION['logged_in'] = true;
		$_SESSION['username'] = $request->data['username'];

		header("Location: ../Account");
	}

	public function logout()
	{
		unset($_SESSION['logged_in']);
		unset($_SESSION['username']);

		session_destroy();
		header("Location: ../");
	}

	public function getLoginStatus()
	{
		if (!isset($_SESSION['logged_in']) || !isset($_SESSION['username'])) {
			unset($_SESSION['logged_in']);
			return;
		}

		return true;
	}

	public function isAdmin()
	{
		$row = $this->user->isAdmin();

		if ($row['user_group'] != 2) {
			return;
		}

		return true;
	}
}
