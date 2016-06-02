<?php

namespace UserControlSkeleton\Models\User;

use PDO;
use UserControlSkeleton\Requests;
use UserControlSkeleton\Interfaces\UserInterface;
use UserControlSkeleton\Models\Database\MySQLDatabase;

class User implements UserInterface
{
	protected $username;

	public function __construct()
	{
		$this->database = new MySQLDatabase();
		$this->username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
	}

	public function create(Requests $request, $userGroup = '1')
	{
		if ($this->exists($request->get('username'))) {
			return;
		}

		$password = password_hash($request->get('password'), PASSWORD_BCRYPT);
		$statement = $this->database->connect();
		$statement = $statement->prepare('INSERT INTO users (user, password, first_name, last_name, user_group)
		VALUES (?, ?, ?, ?, ?)');

		$statement->execute([
			$request->get('username'),
			$password,
			$request->get('first_name'),
			$request->get('last_name'),
			$userGroup
		]);

		return true;
	}

	public function update($username, $password, $firstName, $lastName)
	{
		$database = $this->getPassword($username);

		if (!password_verify($password, $this->getPassword($username))) {
			return;
		}

		$statement = $this->database->connect();
		$statement = $statement->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user = ?');

		$statement->execute([$firstName, $lastName, $username]);

		return true;
	}

	public function exists($user)
	{
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT user FROM users WHERE user = ?');

		$statement->execute([$user]);

		while ($field = $statement->fetch(PDO::FETCH_ASSOC)) {
			return true;
		}

		return;
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

	public function getPassword($username)
	{
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT password FROM users WHERE user = ?');

		$statement->execute([$username]);

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result['password'];
	}

	public function search($searchTerms)
	{
		$results = [];
		$statement = $this->database->connect();
		$statement = $statement->prepare('SELECT * FROM users WHERE user LIKE ? OR first_name LIKE ? or last_name LIKE ?');

		$params = array("%$searchTerms%", "%$searchTerms%", "%$searchTerms%");
		$statement->execute($params);

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}

		return $results;
	}
}
