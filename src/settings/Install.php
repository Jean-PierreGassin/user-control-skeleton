<?php

namespace UserControlSkeleton\Settings;

use mysqli;

class Install {
  function check_install()
  {
    include($_SERVER['DOCUMENT_ROOT'] . '/Settings/settings.php');

    if (!empty($DATABASE_HOST) && !empty($DATABASE_NAME) && !empty($DATABASE_USER) && !empty($DATABASE_PWRD) && !empty($DATABASE_PORT))
    {
      return true;
    } 
  }

  function test_database($DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD, $DATABASE_NAME, $DATABASE_PORT, $admin_user, $admin_pass)
  {
    $link = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD);

    if ($link->connect_error)
    {
      return false;
    }
    else
    {
      
      // need to add condition to check if registering user exists !!
      function db_create_update($link, $DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD, $DATABASE_NAME, $DATABASE_PORT, $admin_user, $admin_pass)
      {
        $create_db = mysqli_query($link, 'CREATE DATABASE IF NOT EXISTS ' . $DATABASE_NAME . ';');

        $link = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD, $DATABASE_NAME, $DATABASE_PORT);

        $create_table = mysqli_query($link, 'CREATE TABLE IF NOT EXISTS users (
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(30) UNIQUE NOT NULL,
        password VARCHAR(100) NOT NULL,
        first_name VARCHAR(30) NOT NULL,
        last_name VARCHAR(30) NOT NULL,
        user_group INT(2) NOT NULL);');

        $password = password_hash($admin_pass, PASSWORD_BCRYPT);
        $create_admin = mysqli_query($link, 'INSERT INTO users (user, password, first_name, last_name, user_group) 
          VALUES ("' . $admin_user . '", "' . $password . '", "Administrator", "Administrator", "2");');

        if (!$create_db)
        {
          echo mysql_error();
          return false;
        }
        
        if (!$create_table)
        {
          echo mysql_error();
          return false;
        }
        
        if (!$create_admin)
        {
          echo mysql_error();
          return false;
        }

        return true;
      }

      if (db_create_update($link, $DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD, $DATABASE_NAME, $DATABASE_PORT, $admin_user, $admin_pass))
      {
        return true;
      }
    } 
  }

	function write_settings()
	{
    if (isset($_POST['run_install']) && !empty($_POST['db_host']) && !empty($_POST['db_name']) && !empty($_POST['db_user']) && !empty($_POST['db_pwrd']) && !empty($_POST['db_port']) && !empty($_POST['admin_user']) && !empty($_POST['admin_pass']) && !empty($_POST['admin_pass_confirm']))
    {
      $DATABASE_HOST = $_POST['db_host'];
      $DATABASE_NAME = $_POST['db_name'];
      $DATABASE_USER = $_POST['db_user'];
      $DATABASE_PWRD = $_POST['db_pwrd'];
      $DATABASE_PORT = $_POST['db_port'];
      $admin_user = $_POST['admin_user'];
      $admin_pass = $_POST['admin_pass'];
      $admin_pass_confirm = $_POST['admin_pass_confirm'];

      if ($admin_pass === $admin_pass_confirm)
      {
        if ($this->test_database($DATABASE_HOST, $DATABASE_USER, $DATABASE_PWRD, $DATABASE_NAME, $DATABASE_PORT, $admin_user, $admin_pass))
        {
          $settings = fopen($_SERVER['DOCUMENT_ROOT'] . '/Settings/settings.php', 'w');
          $newSettings = array(
  '<?php
    $DATABASE_HOST = "' . $DATABASE_HOST . '";
    $DATABASE_NAME = "' . $DATABASE_NAME . '";
    $DATABASE_USER = "' . $DATABASE_USER . '";
    $DATABASE_PWRD = "' . $DATABASE_PWRD . '";
    $DATABASE_PORT = "' . $DATABASE_PORT . '";
  ?>'
          );

          file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/Settings/settings.php', $newSettings);

          header('Location: index.php'); 
        }
      }
      else
      {
        echo '
        <div class="row">&nbsp;</div>
        <div class="row">
          <div class="large-12 columns">
            <div>
              <div>
                <div class="large-4 large-centered text-center columns">
                  <div class="alert-box alert">Passwords do not match.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        ';
      }
    }
	}
}

$install = new install();
$install->check_install();
$install->write_settings();


