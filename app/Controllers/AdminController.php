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

		if (!$this->user->isAdmin()) {
			return;
		}

		$results = $this->user->searchUsers($search);

		foreach ($results as $result) {
			return $result;
		}
	}

	public function deleteUser()
	{
		//TODO
	}
}
