<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Request;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Controllers\DatabaseController;

class AdminController extends DatabaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User($this->adapter);
    }

    public function getColumns()
    {
        return $this->adapter->getColumns();
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('search_field');

        return $this->user->search($search);
    }

    public function deleteUser()
    {
        //TODO
    }
}
