<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\Database;
use UserControlSkeleton\Models\GenerateView;
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
		if (!empty($request->data['username']) && !empty($request->data['password'])) {
			$this->authenticateUser($request->data['username'], $request->data['password']);
		}

		GenerateViewWithMessage::renderView('error', 'Incorrect login details.');
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
		if ($this->user->isAdmin()) {
			return true;
		}
	}

	public function authenticateUser($username, $password)
	{
		if ($this->user->comparePasswords($username, $password)) {
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $username;

			header("Location: ../Account");
			return;
		}

		unset($_SESSION['logged_in']);
		unset($_SESSION['username']);
	}
}
