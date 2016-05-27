<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\Database;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class UserController
{
	protected $user;

	public function __construct()
	{
		$this->user = new User();
	}

	public function login()
	{
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$this->authenticateUser($username, $password);
		}

		GenerateViewWithMessage::renderView('error', 'Incorrect login details.');
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

	public function logout()
	{
		unset($_SESSION['logged_in']);
		unset($_SESSION['username']);

		session_destroy();
		header("Location: ../");
	}

	public function create()
	{
		$formData = [
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'password2' => $_POST['password_confirm'],
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name']
		];

		foreach ($formData as $post) {
			if (empty($post)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');
				return;
			}
		}

		if ($formData['password'] !== $formData['password2']) {
			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
			return;
		}

		if (!$this->user->createUser($formData)) {
			GenerateViewWithMessage::renderView('error', 'Username already exists.');
			return;
		}

		$this->authenticateUser($formData['username'], $formData['password']);
	}

	public function delete()
	{
		//TODO
	}

	public function getInfo()
	{
		if ($this->getLoginStatus()) {
			return $this->user->getUserInfo();
		}

		GenerateViewWithMessage::renderView('error', 'You must be logged in.');
	}

	public function getColumns()
	{
		return $this->user->getColumns();
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
		$username = $_SESSION['username'];

		if ($this->user->getUserAccess($username)) {
			return true;
		}
	}

	public function searchUsers($search)
	{
		if ($this->isAdmin()) {
			$results = $this->user->searchUsers($search);

			foreach ($results as $result) {
				return $result;
			}
		}
	}

	public function updateUser()
	{
		if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) &&
		!empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
			$username = $_SESSION['username'];
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$dbPassword = $_POST['db_pass'];
			$newPassword = $_POST['new_pass'];
			$newPassword2 = $_POST['confirm_pass'];

			if ($newPassword === $newPassword2) {
				if ($this->user->updateUserPassword($username, $dbPassword, $newPassword)) {
					GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
				} else {
					GenerateViewWithMessage::renderView('error', 'Wrong password.');
				}
			} else {
				GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
			}
		}

		if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) &&
		empty($_POST['new_pass'])) {
			$username = $_SESSION['username'];
			$firstName = $_POST['first_name'];
			$lastName = $_POST['last_name'];
			$dbPassword = $_POST['db_pass'];

			if ($this->user->updateUser($username, $dbPassword, $firstName, $lastName)) {
				GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
			} else {
				GenerateViewWithMessage::renderView('error', 'Wrong password.');
			}
		}
	}
}
