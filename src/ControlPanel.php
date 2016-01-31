<?php

namespace UserControlSkeleton;

use UserControlSkeleton\Models\User;
use UserControlSkeleton\Models\GenerateViewWithMessage;
use UserControlSkeleton\Settings\Install;

require dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/autoload.php';

session_start();

include_once('Views/Header.php');

include('Views/Navbar.php');

if ($user->getAccess())
{
	GenerateViewWithMessage::renderView('controlPanel');
}
else
{
	GenerateViewWithMessage::renderView('error', 'Unauthorized!');
}

include_once('Views/Footer.php');
