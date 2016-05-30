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
		$requests = $request->data;

		foreach ($requests as $field) {
			if (!isset($field)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');

				return;
			}
		}

		if ($requests['password'] !== $requests['password_confirm']) {
			GenerateViewWithMessage::renderView('error', 'Passwords do not match.');

			return;
		}

		if (!$this->user->createUser($requests)) {
			GenerateViewWithMessage::renderView('error', 'Username already exists.');

			return;
		}

		$this->auth->login($request);
	}

	public function updateUser(RequestController $request)
	{
		$request = $request->data;

		foreach ($request as $field) {
			if (!isset($field)) {
				GenerateViewWithMessage::renderView('error', 'All fields are required.');

				return;
			}
		}

		if (empty($request['first_name']) || empty($request['last_name'])) {
			GenerateViewWithMessage::renderView('error', 'First name and last name are required.');

			return;
		}

		if ($this->user->updateUser($request['username'], $request['current_password'], $request['first_name'], $request['last_name'])) {
			GenerateViewWithMessage::renderView('success', 'Updated information successfully.');

			return;
		} else {
			GenerateViewWithMessage::renderView('error', 'Wrong password.');

			return;
		}

		//TODO Add the ability to update password

		GenerateViewWithMessage::renderView('error', 'Passwords do not match.');

		return;
	}
}
