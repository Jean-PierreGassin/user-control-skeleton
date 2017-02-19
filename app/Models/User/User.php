<?php

namespace UserControlSkeleton\Models\User;

use PDO;
use UserControlSkeleton\Request;
use UserControlSkeleton\Interfaces\UserInterface;
use UserControlSkeleton\Interfaces\AdapterInterface;

class User
{
    protected $adapter;

    protected $username;

    protected $timestamp;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
        $this->timestamp = date('Y-m-d G:i:s');
    }

    public function create(Request $request, $userGroup = '1')
    {
        $password = password_hash($request->get('password'), PASSWORD_BCRYPT);

        $bindings = [
            'user' => $request->get('username'),
            'password' => $password,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'user_group' => $userGroup,
            'created_at' => $this->timestamp
        ];

        $this->adapter->insert('users', $bindings);

        return true;
    }

    public function update(Request $request)
    {
        if (!password_verify($request->get('current_password'), $this->getPassword($username))) {
            return;
        }

        if (!empty($request->get('new_password')) && !empty($request->get('password_confirm'))) {
            $password = password_hash($request->get('new_password'), PASSWORD_BCRYPT);

            $bindings = [
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'password' => $password,
                'updated_at' => $this->timestamp,
                'user' => $request->get('username')
            ];

            $this->adapter->update('users', $bindings, 'user', '=', $request->get('username'));

            return true;
        }

        $bindings = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'updated_at' => $this->timestamp,
            'user' => $request->get('username')
        ];

        $this->adapter->update('users', $bindings, 'user', '=', $request->get('username'));

        return true;
    }

    public function exists(Request $request)
    {
        $results = $this->adapter->select('user', 'users', 'user', '=', $request->get('username'), true);
        
        return (count($results) > 0);
    }

    public function isAdmin()
    {
        return $this->adapter->select('user_group', 'users', 'user', '=', $this->username);
    }

    public function getInfo()
    {
        return $this->adapter->select('*', 'users', 'user', '=', $this->username);
    }

    public function getPassword($username)
    {
        $result = $this->adapter->select('password', 'users', 'user', '=', $username);

        return $result['password'];
    }

    public function search($searchTerms)
    {
        return $this->adapter->select('*', 'users', 'user', 'LIKE', "%$searchTerms%", true);
    }
}
