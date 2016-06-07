<?php

namespace UserControlSkeleton\Models\User;

use PDO;
use UserControlSkeleton\Request;
use UserControlSkeleton\Interfaces\UserInterface;
use UserControlSkeleton\Interfaces\AdapterInterface;

class User
{
	protected $adapter;

	protected $username;

	protected $timestamp;

	public function __construct(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
		$this->username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
		$this->timestamp = date('Y-m-d G:i:s');
	}

	public function create(Request $request, $userGroup = '1')
	{
		if ($this->exists($request->get('username'))) {
			return;
		}

		$password = password_hash($request->get('password'), PASSWORD_BCRYPT);
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('INSERT INTO users (user, password, first_name, last_name, user_group, created_at) VALUES (?, ?, ?, ?, ?, ?)');

		$statement->execute([
			$request->get('username'),
			$password,
			$request->get('first_name'),
			$request->get('last_name'),
			$userGroup,
			$this->timestamp
		]);

		return true;
	}

	public function update(Request $request)
	{
		$statement = $this->adapter->connect();
		$username = $request->get('username');
		$password = $request->get('new_password');
		$firstName = $request->get('first_name');
		$lastName = $request->get('last_name');

		if (!password_verify($request->get('current_password'), $this->getPassword($username))) {
			return;
		}

		if (!empty($password) && !empty($request->get('password_confirm'))) {
			$password = password_hash($password, PASSWORD_BCRYPT);
			$statement = $statement->prepare('UPDATE users SET first_name = ?, last_name = ?, password = ?, updated_at = ? WHERE user = ?');

			$statement->execute([$firstName, $lastName, $password, $username, $this->timestamp]);

			return true;
		}

		$statement = $statement->prepare('UPDATE users SET first_name = ?, last_name = ?, updated_at = ? WHERE user = ?');

		$statement->execute([$firstName, $lastName, $this->timestamp, $username]);

		return true;
	}

	public function exists($user)
	{
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('SELECT user FROM users WHERE user = ?');

		$statement->execute([$user]);

		while ($field = $statement->fetch(PDO::FETCH_ASSOC)) {
			return true;
		}

		return;
	}

	public function isAdmin()
	{
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('SELECT user_group FROM users WHERE user = ?');

		$statement->execute([$this->username]);

		$row = $statement->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function getInfo()
	{
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('SELECT * FROM users WHERE user = ?');

		$statement->execute([$this->username]);

		return $statement->fetch(PDO::FETCH_ASSOC);;
	}

	public function getPassword($username)
	{
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('SELECT password FROM users WHERE user = ?');

		$statement->execute([$username]);

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result['password'];
	}

	public function search($searchTerms)
	{
		$results = [];
		$statement = $this->adapter->connect();
		$statement = $statement->prepare('SELECT * FROM users WHERE user LIKE ? OR first_name LIKE ? or last_name LIKE ?');

		$params = array("%$searchTerms%", "%$searchTerms%", "%$searchTerms%");
		$statement->execute($params);

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}

		return $results;
	}
}
