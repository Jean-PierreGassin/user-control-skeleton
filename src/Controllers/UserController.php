<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\Database;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class UserController
{
	protected $user;

	protected $formData;

	public function __construct()
	{
		$this->user = new User();

		$this->formData = [
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'password2' => $_POST['password_confirm'],
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name']
		];
	}

	public function login()
	{
		if (!empty($this->formData['username']) && !empty($this->formData['password'])) {
			$this->authenticateUser($this->formData['username'], $this->formData['password']);
		}

		GenerateViewWithMessage::renderView('error', 'Incorrect login details.');
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

	public function getInfo()
	{
		return $this->user->getInfo();
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
		foreach ($this->formData as $post) {
			if (empty($post)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');
				return;
			}
		}

		if ($this->formData['password'] !== $this->formData['password2']) {
			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
			return;
		}

		if (!$this->user->createUser($this->formData)) {
			GenerateViewWithMessage::renderView('error', 'Username already exists.');
			return;
		}

		$this->authenticateUser($this->formData['username'], $this->formData['password']);
	}

	public function delete()
	{
		//TODO
	}

	public function updateUser()
	{
		$formData[] = [
			'current_password' => $_POST['current_password']
		];

		if (isset($_POST['update_user']) && !empty($this->formData['first_name']) && !empty($this->formData['last_name']) && !empty($_POST['current_password']) && empty($this->formData['password'])) {
			if ($this->user->updateUser($this->formData['username'], $this->formData['current_password'], $this->formData['first_name'], $this->formData['last_name'])) {
				GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
			} else {
				GenerateViewWithMessage::renderView('error', 'Wrong password.');
			}
		}

		foreach ($this->formData as $post) {
			if (empty($post)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');
				return;
			}

			if ($this->user->updateUserPassword($this->formData['username'], $_POST['current_password'], $this->formData['password'])) {
				GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
				return;
			} else {
				GenerateViewWithMessage::renderView('error', 'Wrong password.');
			}

			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
			return;
		}
	}
}
