<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\Database\MySQLDatabase;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class UserController
{
	protected $user;

	public function __construct()
	{
		$this->user = new User();
		$this->auth = new AuthController();
	}

	public function getInfo()
	{
		return $this->user->getInfo();
	}

	public function create(RequestController $request)
	{
		foreach ($request as $field) {
			if (empty($field)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');

				return;
			}
		}

		if ($request->data['password'] !== $request->data['password_confirm']) {
			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');

			return;
		}

		if (!$this->user->createUser($request->data)) {
			GenerateViewWithMessage::renderView('error', 'Username already exists.');

			return;
		}

		$this->auth->authenticateUser($request->data['username'], $request->data['password']);
	}

	public function updateUser(RequestController $request)
	{
		$username = isset($request->data['username']) ? $request->data['username'] : false;
		$firstName = isset($request->data['first_name']) ? $request->data['first_name'] : false;
		$lastName = isset($request->data['last_name']) ? $request->data['last_name'] : false;
		$currentPassword = isset($request->data['current_password']) ? $request->data['current_password'] : false;
		$newPassword = isset($request->data['new_password']) ? $request->data['new_password'] : false;
		$confirmPassword = isset($request->data['password_confirm']) ? $request->data['password_confirm'] : false;

		foreach ($request->data as $field) {
			if (empty($field)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');

				return;
			}

			if (!$username || !$firstName || !$lastName || !$currentPassword) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');

				return;
			}

			if ($this->user->updateUser($username, $currentPassword, $firstName, $lastName)) {
				GenerateViewWithMessage::renderView('success', 'Updated information successfully.');

				return;
			} else {
				GenerateViewWithMessage::renderView('error', 'Wrong password.');

				return;
			}

			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');

			return;
		}
	}
}
