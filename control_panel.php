<?php 
session_start();
require_once('php_scripts/loader.php'); 
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

    <?php include('navbar.php'); ?>

    <?php if (check_user_status()): ?>
    <?php if (user_has_access()): ?>
    <div class="row">
      <div class="large-12 columns">

        <form method="POST" class="large-12 columns">
          <div class="row collapse">
            <div class="small-9 columns">
              <input type="text" name="search_field"/>
            </div>
            <div class="small-3 columns">
              <button class="postfix" type="submit" name="search_users">Search Users</button>
            </div>
          </div>
        </form>

        <?php if (isset($_POST['search_users'])): ?>
          <?php search_users(array($_POST['search_field']));?>
        <?php endif; ?>

      </div>
    </div>  
    <?php else: ?>
    <div class="row">
      <div class="large-12 columns">
        <div class="large-12 large-centered text-center columns">
          <div class="alert-box alert">ERROR: Unauthorized!</div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?> 

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
