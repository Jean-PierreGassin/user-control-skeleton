<?php

class database
{
	function database()
	{
		function db_connect()
		{
			include('settings/settings.php');

			$db_user = $DATABASE_USER;
			$db_pass = $DATABASE_PWRD;
			$db_host = $DATABASE_HOST;
			$db_port = $DATABASE_PORT;
			$db_name = $DATABASE_NAME;


			$link = new mysqli($db_host, $db_user, $db_pass, $db_name);

			if ($link->connect_error)
			{
				printf("<br/>Database Connection failed: %s\n", $link->connect_error);
				return false;
			} 
			else
			{
				return $link;
			}
		}

		function db_create_user($username, $password, $fname, $lname)
		{
			$auth_password = $password;
			$password = password_hash($password, PASSWORD_BCRYPT);
			$user_group = "1";

			if ($link = db_connect())
			{
				if ($query = $link->prepare('INSERT INTO users (user, password, first_name, last_name, user_group) VALUES (?, ?, ?, ?, ?)'))
				{			
					$query->bind_param('sssss', $username, $password, $fname, $lname, $user_group);
					$query->execute();
					$query->close();
					$link->close();

					if (db_auth_user($username, $auth_password))
					{
						return true;
					}
				}
			}
		}

		function db_update_user($username, $form_pass, $fname, $lname)
		{
			if ($link = db_connect())
			{
				if (db_compare_pass($username, $form_pass))
				{
					if ($query = $link->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user = ?'))
					{
						$query->bind_param('sss', $fname, $lname, $username);
						$query->execute();
						$query->close();
						$link->close();

						return true;
					}
				}
			}
		}

		function db_update_user_password($username, $form_pass, $new_pass)
		{
			if ($link = db_connect())
			{
				if (db_compare_pass($username, $form_pass))
				{
					if ($query = $link->prepare('UPDATE users SET password = ? WHERE user = ?'))
					{
						$new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
						$query->bind_param('ss', $new_pass, $username);
						$query->execute();
						$query->close();
						$link->close();

						return true;
					}
				}
			}
		}

		function db_compare_pass($username, $form_pass)
		{
			if ($link = db_connect())
			{
				if ($query = $link->prepare('SELECT password FROM users WHERE user = ?'))
				{
					$query->bind_param('s', $username);
					$query->execute();
					$result = $query->get_result();
					$query->close();
					$link->close();

					while ($field = $result->fetch_array(MYSQLI_ASSOC))
					{
						foreach ($field as $db_password)
						{
							if (password_verify($form_pass, $db_password))
							{
								return true;
							}
						}
					}	
				}
			}
		}

		function db_auth_user($username, $password)
		{
			if (db_compare_pass($username, $password))
			{
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['username'] = $username;
				return true;
			} 
			else
			{
				unset($_SESSION['logged_in']);
				unset($_SESSION['username']);
			}
		}

		function db_search_users($search)
		{
			if ($link = db_connect())
			{
				generate_view::new_view('open_table');
				generate_view::new_view('open_table_head');

				if ($query = $link->prepare('SHOW COLUMNS FROM users'))
				{
					$query->execute();
					$result = $query->get_result();
					$query->close();
				}

				while ($field = $result->fetch_array(MYSQLI_ASSOC))
				{
					generate_view::new_view_array('user_table_headings', $field['Field']);
				}	

				generate_view::new_view('close_table_head');

				foreach ($search as $item)
				{
					$item = '%' . $item . '%';

					if ($query = $link->prepare('SELECT * FROM users WHERE user LIKE ? OR first_name LIKE ? OR last_name LIKE ?'))
					{
						$query->bind_param("sss", $item, $item, $item);
						$query->execute();
						$result = $query->get_result();
						$query->close();
						$link->close();

						while ($field = $result->fetch_array(MYSQLI_ASSOC))
						{
							generate_view::new_view_array('user_table_cells', $field);
						}
					}

					generate_view::new_view('close_table');
				}
			}
		}

		function db_get_user_info()
		{
			if ($link = db_connect())
			{
				$username = $_SESSION['username'];

				if ($query = $link->prepare('SELECT * FROM users WHERE user = ?'))
				{
					$query->bind_param('s', $username);
					$query->execute();
					$result = $query->get_result();
					$query->close();
					$link->close();

					while ($row = $result->fetch_array(MYSQLI_ASSOC))
					{
						generate_view::new_view_array('update_page', $row);
					}
				}
			}
		}

		function db_check_user_access($username)
		{
			if ($link = db_connect())
			{
				if ($query = $link->prepare('SELECT user_group FROM users WHERE user = ?'))
				{
					$query->bind_param('s', $username);
					$query->execute();
					$result = $query->get_result();
					$query->close();
					$link->close();

					while ($row = $result->fetch_array(MYSQLI_ASSOC))
					{
						if ($row['user_group'] == 2)
						{
							return true;
						}
					}
				}
			}
		}		
	}	
}

$database = new database();
?>