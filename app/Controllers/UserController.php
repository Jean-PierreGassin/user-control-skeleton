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

		foreach ($request as $field) {
			if (empty($field)) {
				$view->render('error', 'All fields are required');

				return;
			}
		}

		if ($request->get('password') !== $request->get('password_confirm')) {
			$view->render('error', 'Passwords do not match');

			return;
		}

		if (!(new User)->create($request)) {
			$view->render('error', 'Username already exists');

			return;
		}

		(new AuthController)->login($request);
	}

	public function update(Requests $request)
	{
		$view = new GenerateView();

		if (empty($request->get('first_name')) || empty($request->get('last_name'))) {
			$view->render('error', 'First name and last name are required');

			return;
		}

		if ((new User)->update($request->get('username'), $request->get('current_password'), $request->get('first_name'), $request->get('last_name'))) {
			$view->render('success', 'Updated information successfully');

			return;
		} else {
			$view->render('error', 'Wrong password');

			return;
		}

		//TODO Add the ability to update password

		$view->render('error', 'Passwords do not match');

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
