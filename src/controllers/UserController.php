<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\Database;
use UserControlSkeleton\Models\GenerateView;
use UserControlSkeleton\Models\GenerateViewWithMessage;

class UserController
{
    public function database()
    {
        $database = new Database;

        return $database;
    }

    public function login()
    {
        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $this->authenticateUser($username, $password);
        }

        GenerateViewWithMessage::renderView('error', 'Incorrect login details.');
    }

    public function authenticateUser($username, $password)
    {
        if ($this->database()->comparePasswords($username, $password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;

            header("Location: ../Account");
        } else {
            unset($_SESSION['logged_in']);
            unset($_SESSION['username']);
        }
    }

    public function logout()
    {
        session_start();

        unset($_SESSION['logged_in']);
        unset($_SESSION['username']);

        session_destroy();

        header("Location: ../index.php");
    }

    public function create()
    {
        if (isset($_POST['register_user']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_confirm']) &&
            !empty($_POST['first_name']) && !empty($_POST['last_name'])) {
            $username = $_POST['username'];
            $password1 = $_POST['password'];
            $password2 = $_POST['password_confirm'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];

            if ($password1 === $password2) {
                $this->database()->createUser($username, $password1, $firstName, $lastName);

                $this->authenticateUser($username, $password1);

                GenerateViewWithMessage::renderView('error', 'Username already exists.');
            } else {
                GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
            }
        }
    }

    public function delete()
    {
    }

    public function getInfo()
    {
        if ($this->getLoginStatus()) {
            $user = $this->database()->getUserInfo();

            return $user;
        }

        GenerateViewWithMessage::renderView('error', 'You must be logged in.');
    }

    public function getColumns()
    {
        $columns = $this->database()->getColumns();

        return $columns;
    }

    public function getLoginStatus()
    {
        if (isset($_SESSION['logged_in']) && isset($_SESSION['username'])) {
            return true;
        }

        unset($_SESSION['logged_in']);
    }

    public function isAdmin()
    {
        $username = $_SESSION['username'];

        if ($this->database()->getUserAccess($username)) {
            return true;
        }
    }

    public function getActivity()
    {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            session_unset();
            session_destroy();
        }

        $_SESSION['LAST_ACTIVITY'] = time();

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 1800) {
            session_regenerate_id(true);

            $_SESSION['CREATED'] = time();
        }
    }

    public function searchUsers($search)
    {
        if ($this->isAdmin()) {
            $results = $this->database()->searchUsers($search);

            foreach ($results as $result) {
                return $result;
            }
        }
    }

    public function updateUser()
    {
        if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) &&
            !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
            $username = $_SESSION['username'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $dbPassword = $_POST['db_pass'];
            $newPassword = $_POST['new_pass'];
            $newPassword2 = $_POST['confirm_pass'];

            if ($newPassword === $newPassword2) {
                if ($this->database()->updateUserPassword($username, $dbPassword, $newPassword)) {
                    GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
                } else {
                    GenerateViewWithMessage::renderView('error', 'Wrong password.');
                }
            } else {
                GenerateViewWithMessage::renderView('error', 'Passwords do not match.');
            }
        }

        if (isset($_POST['update_user']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['db_pass']) &&
            empty($_POST['new_pass'])) {
            $username = $_SESSION['username'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $dbPassword = $_POST['db_pass'];

            if ($this->database()->updateUser($username, $dbPassword, $firstName, $lastName)) {
                GenerateViewWithMessage::renderView('success', 'Updated information successfully.');
            } else {
                GenerateViewWithMessage::renderView('error', 'Wrong password.');
            }
        }
    }
}
