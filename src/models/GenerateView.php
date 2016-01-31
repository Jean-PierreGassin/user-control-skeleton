<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
    public static function renderView($view)
    {
        switch($view) {
            case('/'):
            return include('Views/Home.php');
            break;

            case('/UserNavBar'):
            return include('Views/UserNavBar.php');
            break;

            case('/GuestNavBar'):
            return include('Views/GuestNavBar.php');
            break;

            case('/AdminNavBar'):
            return include('Views/AdminNavBar.php');
            break;

            case('/Register'):
            return include('Views/Register.php');
            break;

            case('/Logout'):
            return include('Views/Logout.php');
            break;

            case('/controlPanel'):
            return include('Views/ControlPanel.php');
            break;

            default:
            return include('Views/Home.php');
            break;
        }
    }
}
