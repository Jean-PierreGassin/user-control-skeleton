<?php

class login extends database
{
	function login_user()
	{
		if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];

			if ($this->db_auth_user($username, $password))
			{
				header('Location: index.php');
			}
		}
	}
}

global $login;
$login = new login;
$login->login_user();
?>