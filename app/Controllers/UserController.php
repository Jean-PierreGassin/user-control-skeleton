<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Requests;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\Database\MySQLDatabase;

class UserController
{
	public function create(Requests $request)
	{
		$view = new GenerateView();
		$requests = $request->data;

		foreach ($requests as $field) {
			if (empty($field)) {
				$view->render('error', 'All fields are required.');

				return;
			}
		}

		if ($requests['password'] !== $requests['password_confirm']) {
			$view->render('error', 'Passwords do not match.');

			return;
		}

		if (!(new User)->create($requests)) {
			$view->render('error', 'Username already exists.');

			return;
		}

		(new AuthController)->login($request);
	}

	public function update(Requests $request)
	{
		$view = new GenerateView();
		$request = $request->data;

		if (empty($request['first_name']) || empty($request['last_name'])) {
			$view->render('error', 'First name and last name are required.');

			return;
		}

		if ((new User)->update($request['username'], $request['current_password'], $request['first_name'], $request['last_name'])) {
			$view->render('success', 'Updated information successfully.');

			return;
		} else {
			$view->render('error', 'Wrong password.');

			return;
		}

		//TODO Add the ability to update password

		$view->render('error', 'Passwords do not match.');

		return;
	}

	public function isLoggedIn()
	{
		if (!isset($_SESSION['logged_in']) || !isset($_SESSION['username'])) {
			unset($_SESSION['logged_in']);

			return;
		}

		return true;
	}
}
