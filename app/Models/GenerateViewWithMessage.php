<?php

namespace UserControlSkeleton\Models;

class GenerateViewWithMessage
{
	public static function renderView($view, $message)
	{
		switch($view) {
			case('/Account'):
				return include('../Views/Pages/Account.php');
				break;

			case('UserTable'):
				return include('../Views/UserTable.php');
				break;

			case('error'):
				return include('../Views/Messages/Error.php');
				break;

			case('success'):
				return include('../Views/Messages/Success.php');
				break;
		}
	}
}
