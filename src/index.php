<?php 

namespace UserControlSkeleton;

use UserControlSkeleton\Settings\Install;
use UserControlSkeleton\Models\Login;

require dirname($_SERVER['DOCUMENT_ROOT']) . '/vendor/autoload.php';

session_start();

$installed = new Install;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Example Site</title>
    <link rel="stylesheet" href="stylesheets/app.css" />
    <script src="bower_components/modernizr/modernizr.js"></script>
  </head>
  <body>

<?php

if ($installed->check_install()): 

?>

    <?php include('views/Navbar.php'); ?>
    
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

    <?php else : ?>

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

    <?php endif ?>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/foundation/js/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
