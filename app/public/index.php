<?php

namespace UserControlSkeleton;

use Dotenv\Dotenv;
use UserControlSkeleton\Controllers\RouteController;

require_once __DIR__."/../../vendor/autoload.php";

session_start();

$route = new RouteController();
$dotenv = new Dotenv(__DIR__."/../../");

$dotenv->load();
$route->switchView();

include_once('../Views/Header.php');

include_once('../Views/Footer.php');
