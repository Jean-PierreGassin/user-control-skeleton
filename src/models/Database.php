<?php

namespace UserControlSkeleton\Models;

use PDO;

class Database
{
    public function connect()
    {
        $username = getenv('DATABASE_USER');
        $password = getenv('DATABASE_PASS');
        $host = getenv('DATABASE_HOST');
        $port = getenv('DATABASE_PORT');
        $name = getenv('DATABASE_NAME');
        $driver = getenv('DATABASE_DRIVER');

        try {
            $link = new PDO($driver.':host='.$host.';port='.$port.';dbname='.$name.';charset=UTF8;', $username, $password);

            return $link;
        } catch (\PDOException $e) {
            GenerateViewWithMessage::renderView('error', $e->getMessage());
        }
    }

    public function createUser($username, $password, $fname, $lname, $user_group = '1')
    {
        $userPassword = $password;
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = $this->connect();

        $query = $query->prepare('SELECT user FROM users WHERE user = :username');
        $query->bindParam(':username', $username);
        $query->execute();

        while ($field = $query->fetch(PDO::FETCH_ASSOC)) {
            return false;
        }

        $query = $this->connect();

        $query = $query->prepare('INSERT INTO users (user, password, first_name, last_name, user_group)
            VALUES (:username, :password, :first_name, :last_name, :user_group)');
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $encryptedPassword);
        $query->bindParam(':first_name', $fname);
        $query->bindParam(':last_name', $lname);
        $query->bindParam(':user_group', $user_group);
        $query->execute();

        return true;
    }

    public function updateUser($username, $form_pass, $fname, $lname)
    {
        $query = $this->connect();

        if ($this->comparePasswords($username, $form_pass)) {
            $query = $query->prepare('UPDATE users SET first_name = :first_name, last_name = :last_name WHERE user = :username');
            $query->bindParam(':first_name', $fname);
            $query->bindParam(':last_name', $lname);
            $query->bindParam(':username', $username);
            $query->execute();

            return true;
        }
    }

    public function updateUserPassword($username, $currentPassword, $newPassword)
    {
        $query = $this->connect();

        if ($this->comparePasswords($username, $currentPassword)) {
            $query = $query->prepare('UPDATE users SET password = :password WHERE user = :username');
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            $query->bindParam(':username', $username);
            $query->bindParam(':password', $newPassword);
            $query->execute();

            return true;
        }
    }

    public function comparePasswords($username, $form_pass)
    {
        $query = $this->connect();

        $query = $query->prepare('SELECT password FROM users WHERE user = :username');
        $query->bindParam(':username', $username);
        $query->execute();

        while ($field = $query->fetch(PDO::FETCH_ASSOC)) {
            foreach ($field as $db_password) {
                if (password_verify($form_pass, $db_password)) {
                    return true;
                }
            }
        }
    }

    public function searchUsers($searchTerms)
    {
        $searchTerms = explode(" ", $searchTerms);

        $results = [];

        foreach ($searchTerms as $searchTerm) {
            $searchTerm = '%' . $searchTerm . '%';

            $query = $this->connect();

            $query = $query->prepare('SELECT * FROM users WHERE user LIKE :search OR first_name LIKE :search OR last_name LIKE :search');
            $query->bindParam(":search", $searchTerm);
            $query->execute();

            while ($user[] = $query->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $user;
            }
        }

        return $results;
    }

    public function getColumns()
    {
        $results = [];

        $query = $this->connect();

        $query = $query->prepare('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = "user_control_skeleton" AND TABLE_NAME = "users"');
        $query->execute();

        while ($column = $query->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $column;
        }

        return $results;
    }

    public function getUserInfo()
    {
        $query = $this->connect();

        $username = $_SESSION['username'];

        $query = $query->prepare('SELECT * FROM users WHERE user = :username');
        $query->bindParam(':username', $username);
        $query->execute();

        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            return $user;
        }
    }

    public function getUserAccess($username)
    {
        $query = $this->connect();

        $query = $query->prepare('SELECT user_group FROM users WHERE user = :username');
        $query->bindParam(':username', $username);
        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($row['user_group'] == 2) {
                return true;
            }
        }
    }
}
