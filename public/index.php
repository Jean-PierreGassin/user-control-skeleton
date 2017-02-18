<?php

namespace UserControlSkeleton;

use Dotenv\Dotenv;
use UserControlSkeleton\Routes;

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/app.php";

session_start();

$dotenv = new Dotenv(__DIR__."/../");
$dotenv->load();

$route = new Routes();
$route->switchView();
