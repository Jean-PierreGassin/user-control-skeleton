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
		foreach ($request as $field) {
			if (empty($field)) {
				(new GenerateView)->render('error', 'All fields are required');

				return;
			}
		}

		if ($request->get('password') !== $request->get('password_confirm')) {
			(new GenerateView)->render('error', 'Passwords do not match');

			return;
		}

		if (!(new User)->create($request)) {
			(new GenerateView)->render('error', 'Username already exists');

			return;
		}

		(new AuthController)->login($request);
	}

	public function update(Requests $request)
	{
		if (empty($request->get('first_name')) || empty($request->get('last_name'))) {
			(new GenerateView)->render('error', 'First name and last name are required');

			return;
		}

		if (!empty($request->get('new_password')) && empty($request->get('password_confirm'))) {
			(new GenerateView)->render('error', 'New password and confirm new password do not match');

			return;
		}

		if (empty($request->get('current_password'))) {
			(new GenerateView)->render('error', 'You must confirm your current password');
		}

		if ((new User)->update($request)) {
			(new GenerateView)->render('success', 'Information updated successfully');

			return;
		}

		(new GenerateView)->render('error', 'Incorrect password');

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
