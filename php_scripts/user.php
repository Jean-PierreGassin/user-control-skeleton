<?php

class user extends database
{
	function user()
	{
		function create_user()
		{
			if (isset($_POST['register_user']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_confirm']) && !empty($_POST['first_name']) && !empty($_POST['last_name']))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$password_confirm = $_POST['password_confirm'];
				$fname = $_POST['first_name'];
				$lname = $_POST['last_name'];

				if ($password === $password_confirm)
				{
					if (db_create_user($username, $password, $fname, $lname))
					{
						header('Location: index.php');
					}
					else
					{
						generate_view::new_view('user_exists');
					}
				}
				else
				{
					generate_view::new_view('pass_mismatch');
				}
			}
		}

		function update_user()
		{
			if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass']))
			{
				$username = $_SESSION['username'];
				$fname = $_POST['first_name'];
				$lname = $_POST['last_name'];
				$db_pass = $_POST['db_pass'];
				$new_pass = $_POST['new_pass'];
				$confirm_pass = $_POST['confirm_pass'];

				if ($new_pass === $confirm_pass)
				{
					if (db_update_user_password($username, $db_pass, $new_pass))
					{
						generate_view::new_view('update_success');
					}
					else
					{
						generate_view::new_view('wrong_pass');
					}
				}
				else
				{
					generate_view::new_view('pass_mismatch');
				}
			}

			if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) && empty($_POST['new_pass']))
			{
				$username = $_SESSION['username'];
				$fname = $_POST['first_name'];
				$lname = $_POST['last_name'];
				$db_pass = $_POST['db_pass'];
				
				if (db_update_user($username, $db_pass, $fname, $lname))
				{
					generate_view::new_view('update_success');
				}
				else
				{
					generate_view::new_view('wrong_pass');
				}	
			}
		}

		function search_users($search)
		{
			if (check_user_status())
			{
				if (user_has_access())
				{
					db_search_users($search);
					return true;
				}
				else
				{
					generate_view::new_view('unauthorized');
				}
			}
		}

		function get_user_info()
		{
			if (check_user_status())
			{
				db_get_user_info();
				return true;
			}
		}

		function delete_user()
		{
			if (isset($_POST['delete_user']))
			{

			}
		}

		function check_user_status()
		{
			if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE)
			{
				return true;
			}
		}

		function user_has_access()
		{
			$username = $_SESSION['username'];

			if (db_check_user_access($username))
			{
				return true;
			} 
			else
			{
				return false;
			}
		}

		function check_user_activity()
		{
			if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
			{
			    session_unset();
			    session_destroy();
			}
			$_SESSION['LAST_ACTIVITY'] = time();	

			if (!isset($_SESSION['CREATED'])) 
			{
			    $_SESSION['CREATED'] = time();
			} 
			else if (time() - $_SESSION['CREATED'] > 1800) 
			{
			    session_regenerate_id(true);
			    $_SESSION['CREATED'] = time();
			}
		}
	}
}

$user = new user();
check_user_activity();
create_user();
?>