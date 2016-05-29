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
		$query = $this->database->connect();

		$query = $query->prepare('SELECT user_group FROM users WHERE user = :username');
		$query->bindParam(':username', $username);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			if ($row['user_group'] == 2) {
				return true;
			}
		}
	}

	public function getInfo()
	{
		$username = $_SESSION['username'];
		$query = $this->database->connect();

		$query = $query->prepare('SELECT * FROM users WHERE user = :username');
		$query->bindParam(':username', $username);
		$query->execute();

		while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		}
	}

	public function createUser(array $formData, $userGroup = '1')
	{
		$password = password_hash($formData['password'], PASSWORD_BCRYPT);

		$query = $this->database->connect();

		$query = $query->prepare('SELECT user FROM users WHERE user = :username');
		$query->bindParam(':username', $formData['username']);
		$query->execute();

		while ($field = $query->fetch(PDO::FETCH_ASSOC)) {
			return false;
		}

		$query = $this->database->connect();

		$query = $query->prepare('INSERT INTO users (user, password, first_name, last_name, user_group)
		VALUES (:username, :password, :first_name, :last_name, :user_group)');
		$query->bindParam(':username', $formData['username']);
		$query->bindParam(':password', $password);
		$query->bindParam(':first_name', $formData['first_name']);
		$query->bindParam(':last_name', $formData['last_name']);
		$query->bindParam(':user_group', $userGroup);
		$query->execute();

		return true;
	}

	public function updateUser($username, $form_pass, $fname, $lname)
	{
		$query = $this->database->connect();

		if ($this->comparePasswords($username, $form_pass)) {
			$query = $query->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user = ?');
			$query->execute([$fname, $lname, $username]);

			return true;
		}
	}

	public function updateUserPassword($username, $currentPassword, $newPassword)
	{
		$query = $this->database->connect();

		if ($this->comparePasswords($username, $currentPassword)) {
			$query = $query->prepare('UPDATE users SET password = :password WHERE user = :username');
			$newPassword = password_hash($newPassword, PASSWORD_BCRYPT);

			$query->bindParam(':username', $username);
			$query->bindParam(':password', $newPassword);
			$query->execute();

			return true;
		}
	}

	public function comparePasswords($username, $form_pass)
	{
		$query = $this->database->connect();

		$query = $query->prepare('SELECT password FROM users WHERE user = :username');
		$query->bindParam(':username', $username);
		$query->execute();

		while ($field = $query->fetch(PDO::FETCH_ASSOC)) {
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

		$query = $this->database->connect();
		$query = $query->prepare('SELECT * FROM users WHERE user LIKE ? OR first_name LIKE ? or last_name LIKE ?');

		$params = array("%$searchTerms%", "%$searchTerms%", "%$searchTerms%");
		$query->execute($params);

		while ($user[] = $query->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $user;
		}

		return $results;
	}
}
