<?php

class database
{
	protected function db_connect()
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

	protected function db_create_user($username, $password, $fname, $lname)
	{
		$password = md5($password);

		if ($link = $this->db_connect())
		{
			$query = 'INSERT INTO users (user,password,first_name,last_name,user_group) 
		    VALUES ("' . $username . '", "' . $password . '", "' . $fname . '", "' . $lname . '", "1");';

			if (mysqli_query($link, $query))
			{
				if ($this->db_auth_user($username, $password))
				{
					return true;
				}
			}
		}
	}

	protected function db_update_user($username, $form_pass, $fname, $lname)
	{
		if ($link = $this->db_connect())
		{
			$query = 'SELECT password 
				FROM users 
				WHERE user = "' . $username . '";';

			if ($this->db_compare_pass($username, $form_pass))
			{
				$query = 'UPDATE users 
					SET first_name = "' . $fname . '", last_name = "' . $lname . '" 
					WHERE user = "' . $username . '";';

				if (mysqli_query($link, $query))
				{
					return true;
				}
			}
		}
	}

	protected function db_update_user_password($username, $form_pass, $new_pass)
	{
		if ($link = $this->db_connect())
		{
			$query = 'SELECT password 
				FROM users 
				WHERE user = "' . $username . '";';

			if ($this->db_compare_pass($username, $form_pass))
			{
				$query = 'UPDATE users 
					SET password = "' . $new_pass . '" 
					WHERE user = "' . $username . '";';

				if (mysqli_query($link, $query))
				{
					return true;
				}
			}
		}
	}

	protected function db_compare_pass($username, $form_pass)
	{
		if ($link = $this->db_connect())
		{
			$query = 'SELECT password 
				FROM users 
				WHERE user = "' . $username . '";';

			if ($get_password = mysqli_query($link, $query))
			{
				$result = mysqli_fetch_array($get_password, MYSQLI_ASSOC);
				$db_pass = $result['password'];

				if ($form_pass === $db_pass)
				{
					return true;
				}
			}
		}
	}

	protected function db_auth_user($username, $password)
	{
		if ($link = $this->db_connect())
		{
			$query = 'SELECT password 
				FROM users 
				WHERE user = "' . $username . '";';

			if ($get_password = mysqli_query($link, $query))
			{
				$result = mysqli_fetch_array($get_password, MYSQLI_ASSOC);
				$db_password = $result['password'];

				if ($password === $db_password)
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
		}
	}

	protected function db_search_users($search)
	{
		if ($link = $this->db_connect())
		{
			foreach ($search as $item)
			{
				$query = 'SELECT * FROM users 
				WHERE user 
				LIKE "%' . $item . '%" 
				OR first_name LIKE "%' . $item . '%" 
				OR last_name LIKE "%' . $item . '%";';

				$column_query = 'SHOW COLUMNS FROM users';

				generate_view::new_view('open_table');
				generate_view::new_view('open_table_head');

				if ($result = mysqli_query($link, $column_query))
				{
					while ($row['Field'] = mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
						generate_view::new_view_array('user_table_headings', $row);
					}	
				}
				generate_view::new_view('close_table_head');

				if ($result = mysqli_query($link, $query))
				{
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
						generate_view::new_view_array('user_table_cells', $row);
					}
					generate_view::new_view('close_table');
				}
			}
		}
	}

	protected function db_get_user_info()
	{
		if ($link = $this->db_connect())
		{
			$username = $_SESSION['username'];
			$query = 'SELECT * FROM users WHERE user = "' . $username . '";';
			
			if ($result = mysqli_query($link, $query))
			{
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
				{
					generate_view::new_view_array('update_page', $row);
				}
			}
		}
	}

	protected function db_check_user_access($username)
	{
		if ($link = $this->db_connect())
		{
			$query = 'SELECT user_group FROM users WHERE user = "' . $username . '";';
			
			if ($result = mysqli_query($link, $query))
			{
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
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

?>