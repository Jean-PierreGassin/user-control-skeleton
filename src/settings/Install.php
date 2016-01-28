<?php

namespace UserControlSkeleton\settings;

class Install {
  function check_install()
  {
    include('settings.php');

    if (empty($DATABASE_HOST) || empty($DATABASE_NAME) || empty($DATABASE_USER) || empty($DATABASE_PWRD) || empty($DATABASE_PORT))
    {
      return true;
    } 
    else
    {
      header('Location: ../../index.php');
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
          $settings = fopen('settings.php', 'w');
          $newSettings = array(
  '<?php
    $DATABASE_HOST = "' . $DATABASE_HOST . '";
    $DATABASE_NAME = "' . $DATABASE_NAME . '";
    $DATABASE_USER = "' . $DATABASE_USER . '";
    $DATABASE_PWRD = "' . $DATABASE_PWRD . '";
    $DATABASE_PORT = "' . $DATABASE_PORT . '";
  ?>'
          );

          file_put_contents('settings.php', $newSettings);

          header('Location: ../../index.php'); 
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
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Example Site</title>
    <link rel="stylesheet" href="../../stylesheets/app.css" />
    <script src="../../bower_components/modernizr/modernizr.js"></script>
  </head>
  <body>

    <div class="row">
      <div class="large-12 columns">
        <div>
          <div>
            <div>&nbsp;</div>
             <form method="POST" class="large-6 columns large-centered">
              <div class="row collapse">
                <div class="small-12">
                  <div class="small-12 columns">
                    Database Host:
                    <input type="text" name="db_host"/>
                  </div>
                  <div class="small-12 columns">
                    Database Name (existing or new):
                    <input type="text" name="db_name"/>
                  </div>
                  <div class="small-12 columns">
                    Database Username (e.g: root):
                    <input type="text" name="db_user"/>
                  </div>
                  <div class="small-12 columns">
                    Database Password:
                    <input type="password" name="db_pwrd"/>
                  </div>
                  <div class="small-12 columns">
                    Database Port (Default 3306):
                    <input type="text" value="3306" name="db_port"/>
                  </div>
                  <div class="small-12 columns">
                    Your Username:
                    <input type="text" name="admin_user"/>
                  </div>
                  <div class="small-6 columns">
                    Your Password:
                    <input type="password" name="admin_pass"/>
                  </div>
                  <div class="small-6 columns">
                    Confirm Password:
                    <input type="password" name="admin_pass_confirm"/>
                  </div>
                <div class="small-6 left columns">
                  <button class="button small warning" type="submit" name="run_install">Verify Installation</button>
                </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../bower_components/foundation/js/foundation.min.js"></script>
    <script src="../../js/app.js"></script>
  </body>
</html>
