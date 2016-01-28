<?php

namespace UserControlSkeleton;

function logout()
{
	session_start();
	unset($_SESSION['logged_in']);
	unset($_SESSION['username']);
	session_destroy();
	header("Location: index.php");	
}

logout();