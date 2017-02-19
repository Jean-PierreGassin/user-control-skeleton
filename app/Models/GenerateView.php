<?php

namespace UserControlSkeleton\Models;

use UserControlSkeleton\Controllers\BaseController;

class GenerateView extends BaseController
{
    protected $view;

    protected $message;

    public function render($view, $message = null)
    {
        include_once '../app/Views/Header.php';

        $this->getNavigationBar();

        switch ($view) {
            case ('/'):
                include_once '../app/Views/Pages/Home.php';
                break;

            case ('/Register'):
                include_once '../app/Views/Pages/Register.php';
                break;

            case ('/controlPanel'):
                include_once '../app/Views/Pages/ControlPanel.php';
                break;

            case ('/Account'):
                include_once '../app/Views/Pages/Account.php';
                $this->message = $message;
                break;

            case ('error'):
                $_SESSION['error'] = $message;
                break;

            case ('success'):
                $_SESSION['success'] = $message;
                break;

            default:
                include_once '../app/Views/Pages/Home.php';
        }

        include_once '../app/Views/Footer.php';
    }

    protected function getNavigationBar()
    {
        if ($this->auth->isLoggedIn() && $this->auth->isAdmin()) {
            return include_once '../app/Views/Navigation/AdminNavBar.php';
        }

        if ($this->auth->isLoggedIn()) {
            return include_once '../app/Views/Navigation/UserNavBar.php';
        }

        if (!$this->auth->isLoggedIn()) {
            return include_once '../app/Views/Navigation/GuestNavBar.php';
        }
    }
}
