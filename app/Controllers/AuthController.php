<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Request;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\DatabaseController;

class AuthController extends DatabaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User($this->adapter);
    }

    public function isAdmin()
    {
        $row = $this->user->isAdmin();

        if ((int) $row['user_group'] !== 2) {
            return;
        }

        return true;
    }

    public function login(Request $request)
    {
        if (!$request->get('username') || !$request->get('password')) {
            (new GenerateView)->render('error', 'All fields are required');

            return;
        }

        $username = $request->get('username');
        $password = $request->get('password');

        if (!password_verify($password, $this->user->getPassword($request->get('username')))) {
            unset($_SESSION['logged_in']);
            unset($_SESSION['username']);

            (new GenerateView)->render('error', 'Incorrect login details');

            return;
        }

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        header('location: /Account');
    }

    public function isLoggedIn()
    {
        if (!isset($_SESSION['logged_in']) || !isset($_SESSION['username'])) {
            unset($_SESSION['logged_in']);

            return;
        }

        return true;
    }

    public function logout()
    {
        unset($_SESSION['logged_in']);
        unset($_SESSION['username']);

        session_destroy();
        header('location: /');
    }
}
