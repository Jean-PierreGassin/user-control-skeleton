<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\MySQLDatabase;

class AdminController
{
	public function getColumns()
	{
		$database = new MySQLDatabase();

		return $this->database->getColumns();
	}

	public function searchUsers($search)
	{
		$user =  new User();

		if (!$user->isAdmin()) {
			return;
		}

		return $user->search($search);
	}

	public function deleteUser()
	{
		//TODO
	}
}
