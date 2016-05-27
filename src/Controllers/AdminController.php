<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\Database\Database;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class AdminController
{
	protected $user;

	protected $database;

	public function __construct()
	{
		$this->user = new User();
		$this->database = new Database();
	}

	public function delete()
	{
		//TODO
	}

	public function getColumns()
	{
		return $this->database->getColumns();
	}

	public function searchUsers($search)
	{
		if ($this->user->isAdmin()) {
			$results = $this->user->searchUsers($search);

			foreach ($results as $result) {
				return $result;
			}
		}
	}
}