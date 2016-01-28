<?php

namespace UserControlSkeleton\Models;

use UserControlSkeleton\Database;

class Login extends Database {

	function login_user()
	{
		if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];

			if ($database->db_auth_user($username, $password))
			{
				// header("Location: ../index.php");
			}
		}
	}	

}

$login = new Login();
$login->login_user();
