<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
	public static function render($view)
	{
		switch($view) {
			case('/'):
				return include('../app/Views/Pages/Home.php');
				break;

			case('/UserNavBar'):
				return include('../app/Views/Navigation/UserNavBar.php');
				break;

			case('/GuestNavBar'):
				return include('../app/Views/Navigation/GuestNavBar.php');
				break;

			case('/AdminNavBar'):
				return include('../app/Views/Navigation/AdminNavBar.php');
				break;

			case('/Register'):
				return include('../app/Views/Pages/Register.php');
				break;

			case('/controlPanel'):
				return include('../app/Views/Pages/ControlPanel.php');
				break;

			default:
				return include('../app/Views/Pages/Home.php');
				break;
		}
	}
}
