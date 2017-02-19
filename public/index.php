<?php

namespace UserControlSkeleton;

use Dotenv\Dotenv;
use UserControlSkeleton\Routes;

require_once __DIR__."/../vendor/autoload.php";

date_default_timezone_set('Australia/Brisbane');
session_start();

$dotenv = new Dotenv(__DIR__."/../");
$dotenv->load();

$route = new Routes();
$route->switchView();
