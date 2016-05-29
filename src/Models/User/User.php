<?php

namespace UserControlSkeleton\Models\User;

use PDO;
use UserControlSkeleton\Models\Database\Database;

class User
{
	protected $database;

	public function __construct()
	{
		$this->database = new Database();
	}

	public function isAdmin()
	{
		$username = $_SESSION['username'];
		$statement = $this->database->connect();

		$statement = $statement->prepare('SELECT user_group FROM users WHERE user = ?');
		$statement->execute([$username]);

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			if ($row['user_group'] == 2) {
				return true;
			}
		}
	}

	public function getInfo()
	{
		$username = $_SESSION['username'];
		$statement = $this->database->connect();

		$statement = $statement->prepare('SELECT * FROM users WHERE user = ?');
		$statement->execute([$username]);

		while ($user = $statement->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		}
	}

	public function createUser($request, $userGroup = '1')
	{
		$password = password_hash($request['password'], PASSWORD_BCRYPT);

		$statement = $this->database->connect();

		$statement = $statement->prepare('SELECT user FROM users WHERE user = ?');
		$statement->execute($request['username']);

		while ($field = $statement->fetch(PDO::FETCH_ASSOC)) {
			return false;
		}

		$statement = $this->database->connect();
		$statement = $statement->prepare('INSERT INTO users (user, password, first_name, last_name, user_group)
		VALUES (?, ?, ?, ?, ?)');

		$statement->execute([
			$request['username'],
			$password,
			$request['first_name'],
			$request['last_name'],
			$userGroup
		]);

		return true;
	}

	public function updateUser($username, $form_pass, $fname, $lname)
	{
		$statement = $this->database->connect();

		if ($this->comparePasswords($username, $form_pass)) {
			$statement = $statement->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user = ?');
			$statement->execute([$fname, $lname, $username]);

			return true;
		}
	}

	public function comparePasswords($username, $form_pass)
	{
		$statement = $this->database->connect();

		$statement = $statement->prepare('SELECT password FROM users WHERE user = ?');
		$statement->execute([$username]);

		while ($field = $statement->fetch(PDO::FETCH_ASSOC)) {
			foreach ($field as $db_password) {
				if (password_verify($form_pass, $db_password)) {
					return true;
				}
			}
		}
	}

	public function searchUsers($searchTerms)
	{
		$results = [];

		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT * FROM users WHERE user LIKE ? OR first_name LIKE ? or last_name LIKE ?');

		$params = array("%$searchTerms%", "%$searchTerms%", "%$searchTerms%");
		$statement->execute($params);

		while ($user[] = $statement->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $user;
		}

		return $results;
	}
}
