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
    
    <div class="row">
      <div class="large-12 columns">
        <div>
          <div>

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
              <?php $user->search_users(array($_POST['search_field']));?>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>   

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
