<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\MySQLDatabase;

class AdminController
{
	protected $user;

	protected $database;

	public function __construct()
	{
		$this->user = new User();
		$this->database = new MySQLDatabase();
	}

	public function getColumns()
	{
		return $this->database->getColumns();
	}

	public function searchUsers($search)
	{
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
