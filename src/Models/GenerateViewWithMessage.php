<?php

namespace UserControlSkeleton\Models;

class GenerateViewWithMessage
{
    public static function renderView($view, $message, $message2 = '')
    {
        switch($view) {
            case('/Account'):
            return include('Views/Account.php');
            break;

            case('UserTable'):
            return include('Views/UserTable.php');
            break;

            case('error'):
            return include('Views/Error.php');
            break;

            case('success'):
            return include('Views/Success.php');
            break;
        }
    }
}
