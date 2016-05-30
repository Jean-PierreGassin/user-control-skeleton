<?php

namespace UserControlSkeleton\Models\User;

use PDO;
use UserControlSkeleton\Models\Database\MySQLDatabase;

class User
{
	protected $database;

	protected $username;

	public function __construct()
	{
		$this->database = new MySQLDatabase();
		$this->username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
	}

	public function isAdmin()
	{
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT user_group FROM users WHERE user = ?');

		$statement->execute([$this->username]);

		$row = $statement->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getInfo()
	{
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT * FROM users WHERE user = ?');

		$statement->execute([$this->username]);

		return $statement->fetch(PDO::FETCH_ASSOC);;
	}

	public function createUser($request, $userGroup = '1')
	{
		$password = password_hash($request['password'], PASSWORD_BCRYPT);
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT user FROM users WHERE user = ?');

		$statement->execute([$request['username']]);

		while ($field = $statement->fetch(PDO::FETCH_ASSOC)) {
			return;
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

	public function updateUser($username, $password, $firstName, $lastName)
	{
		$database = $this->getPassword($username);

		if (!password_verify($password, $database['password'])) {
			return;
		}

		$statement = $this->database->connect();
		$statement = $statement->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user = ?');

		$statement->execute([$firstName, $lastName, $username]);

		return true;
	}

	public function getPassword($username)
	{
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT password FROM users WHERE user = ?');

		$statement->execute([$username]);

		return $statement->fetch(PDO::FETCH_ASSOC);
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
