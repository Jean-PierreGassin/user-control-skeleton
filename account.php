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

    <?php update_user(); ?>
    <?php if (get_user_info()): ?>

    <?php else: ?>
    <div class="row">
      <div class="large-12 columns">
        <div class="large-12 large-centered text-center columns">
          <div class="alert-box warning">You are not logged in.</div>
        </div>
      </div>
    </div>
    <?php endif; ?>  

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
