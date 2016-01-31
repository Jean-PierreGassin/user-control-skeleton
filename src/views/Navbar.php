<?php

namespace UserControlSkeleton\Views;

use UserControlSkeleton\Models\User;

?>

<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/index.php">Example Site</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">

    <?php $user = new User;  ?>
    <?php if ($user->getLoginStatus()): ?>
    <ul class="right">
      <li class="has-dropdown">
        <a href="Account.php">Welcome <?php echo $_SESSION['username']; ?>!</a>
        <ul class="dropdown">
          <?php if ($user->getAccess()): ?>
            <li><a href="ControlPanel.php">Control Panel</a></li>
          <?php endif; ?>
          <li><a href="Account.php">My Account</a></li>
          <li><a href="/Views/Logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>

    <?php else: ?>
    <ul class="right">
      <li class="has-form">
        <div class="row collapse">
          <form method="POST" class="row collapse">
            <div class="small-12 medium-3 large-3 columns">
              <input type="text" placeholder="Username" name="username" required/>
            </div>
            <div class="small-12 medium-3 large-3 columns">
              <input type="password" placeholder="Password" name="password" required/>
            </div>
            <div class="small-12 medium-3 large-3 columns">
              <button class="success button expand" type="submit" name="login">Login</button>
            </div>
            <div class="small-12 medium-3 large-3 columns">
              <a class="button expand" href="Register.php">Register</a>
            </div>
          </form>
        </div>
      </li>
    </ul>
    <?php endif; ?>

  </section>
</nav>

<div class="row">
  <div>&nbsp;</div>
</div>
