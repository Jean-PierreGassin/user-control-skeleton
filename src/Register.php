<?php 

namespace UserControlSkeleton;

require '../vendor/autoload.php';

session_start();

?>

<?php 

$user = new User;

$user->create_user(); 

?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Example Site</title>
    <link rel="stylesheet" href="stylesheets/app.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
  </head>
  <body>

    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">Example Site</a></h1>
        </li>
      </ul>

    </nav>

    <div class="row">
      <div>&nbsp;</div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <form method="POST" class="large-4 large-centered columns">
          <div class="large-12 columns">
            <input type="text" placeholder="Username" name="username" maxlength="20"/>
          </div>
          <div class="small-12 columns">
            <input type="password" placeholder="Password" name="password" maxlength="20"/>
          </div>
          <div class="small-12 columns">
            <input type="password" placeholder="Confirm Password" name="password_confirm" maxlength="20"/>
          </div>
          <div class="small-12 columns">
            <input type="text" placeholder="First Name" name="first_name" maxlength="20"/>
          </div>
          <div class="small-12 columns">
            <input type="text" placeholder="Last Name" name="last_name" maxlength="20"/>
          </div>
          <div class="small-12 columns">
            <button class="postfix" type="submit" name="register_user">Register</button>
          </div>
        </form>
      </div>
    </div>

    

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
