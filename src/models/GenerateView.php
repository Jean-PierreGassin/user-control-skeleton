<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
    public static function renderView($view)
    {
        switch($view) {
            case('/'):
            return include('Views/Pages/Home.php');
            break;

            case('/UserNavBar'):
            return include('Views/Navigation/UserNavBar.php');
            break;

            case('/GuestNavBar'):
            return include('Views/Navigation/GuestNavBar.php');
            break;

            case('/AdminNavBar'):
            return include('Views/Navigation/AdminNavBar.php');
            break;

            case('/Register'):
            return include('Views/Pages/Register.php');
            break;

            case('/controlPanel'):
            return include('Views/Pages/ControlPanel.php');
            break;

            default:
            return include('Views/Pages/Home.php');
            break;
        }
    }
}
