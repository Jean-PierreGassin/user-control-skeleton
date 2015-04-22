<?php

class load_modules
{
	function get_modules()
	{
		include('php_scripts/settings/settings.php');

		if (empty($DATABASE_HOST) || empty($DATABASE_NAME) || empty($DATABASE_USER) || empty($DATABASE_PWRD) || empty($DATABASE_PORT))
		{
			header('Location: php_scripts/settings/install.php');
		} 
		else
		{
			$modules = glob('./php_scripts/*php');

			foreach ($modules as $module)
			{
				require_once($module);
			}	
		}
	}
}

$load_modules = new load_modules;
$load_modules->get_modules();
?>