<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Request;
use UserControlSkeleton\Models\User\User;
use UserControlSkeleton\Interfaces\AdapterInterface;
use UserControlSkeleton\Models\Database\MysqlAdapter;

class AdminController
{
    protected $adapter;

    protected $user;

    public function __construct(AdapterInterface $adapter, User $user)
    {
        $this->adapter = $adapter;
        $this->user = $user;
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
