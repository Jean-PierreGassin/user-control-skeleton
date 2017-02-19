<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Request;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Controllers\AuthController;
use UserControlSkeleton\Controllers\DatabaseController;

class UserController extends DatabaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User($this->adapter);
    }

    public function create(Request $request)
    {
        foreach ($request as $field) {
            if (empty($field)) {
                (new GenerateView)->render('error', 'All fields are required');

                return;
            }
        }

        if ($request->get('password') !== $request->get('password_confirm')) {
            (new GenerateView)->render('error', 'Passwords do not match');

            return;
        }

        if ($this->user->exists($request)) {
            (new GenerateView)->render('error', 'Username already exists');

            return;
        }

        $this->user->create($request);

        (new AuthController)->login($request);
    }

    public function update(Request $request)
    {
        if (empty($request->get('first_name')) || empty($request->get('last_name'))) {
            (new GenerateView)->render('error', 'First name and last name are required');

            return;
        }

        if (!empty($request->get('new_password')) && empty($request->get('password_confirm'))) {
            (new GenerateView)->render('error', 'New password and confirm new password do not match');

            return;
        }

        if (empty($request->get('current_password'))) {
            (new GenerateView)->render('error', 'You must confirm your current password');
        }

        if ($this->user->update($request)) {
            (new GenerateView)->render('success', 'Information updated successfully');

            return;
        }

        (new GenerateView)->render('error', 'Incorrect password');

        return;
    }

    public function getInfo()
    {
        return $this->user->getInfo();
    }
}
