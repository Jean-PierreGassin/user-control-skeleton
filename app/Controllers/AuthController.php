<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Request;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\Database\MysqlAdapter;

class AuthController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function isAdmin()
    {
        $row = $this->user->isAdmin();

        if ($row['user_group'] != 2) {
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

        header("Location: ../Account");
    }

    public function logout()
    {
        unset($_SESSION['logged_in']);
        unset($_SESSION['username']);

        session_destroy();
        header("Location: ../");
    }
}
