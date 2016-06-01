<?php

namespace UserControlSkeleton\Models;

class GenerateViewWithMessage
{
	public static function render($view, $message)
	{
		switch($view) {
			case('/Account'):
				return include('../app/Views/Pages/Account.php');
				break;

			case('UserTable'):
				return include('../app/Views/UserTable.php');
				break;

			case('error'):
				return include('../app/Views/Messages/Error.php');
				break;

			case('success'):
				return include('../app/Views/Messages/Success.php');
				break;
		}
	}
}
