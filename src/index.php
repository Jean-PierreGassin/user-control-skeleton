<?php 

namespace UserControlSkeleton;

use UserControlSkeleton\settings\Install;

require '../vendor/autoload.php';

session_start();

$installed = new Install;

if ($installed->check_install()): 

?>

<?php else : ?>
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
        <div class="large-3 large columns">
          <div class="panel">
            <ul class="inline-list">
              <li><a href="#">Sidebar Item 1</a></li>
              <li><a href="#">Sidebar Item 2</a></li>
              <li><a href="#">Sidebar Item 3</a></li>
              <li><a href="#">Sidebar Item 4</a></li>
            </ul>
          </div>
        </div>
        <div class="large-9 large columns">
          <div class="panel">
            <h3>Example Site Index.php</h3>
            <p>This is the landing page of index.php after you've successfully setup your database connection!</p>
          </div>
        </div>
      </div>
    </div>   

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>

<?php endif ?>
