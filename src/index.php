<?php

namespace UserControlSkeleton;

use Dotenv\Dotenv;
use UserControlSkeleton\Controllers\UserController;
use UserControlSkeleton\Controllers\RouteController;

require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();

session_start();

include_once('Views/Header.php');

$user = new UserController;

$route = new RouteController;
$route->switchView();

include_once('Views/Footer.php');
