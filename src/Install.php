<?php

namespace UserControlSkeleton;

use UserControlSkeleton\Models\User;
use UserControlSkeleton\Models\GenerateViewWithMessage;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Settings\Install;

require dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/autoload.php';

session_start();

include_once('Views/Header.php');

include('Views/Navbar.php');

GenerateViewWithMessage::renderView('install');

include_once('Views/Footer.php');
