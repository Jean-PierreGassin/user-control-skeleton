<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="index.php">Example Site</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">

    <?php if ($user->check_user_status()): ?>
    <ul class="right">
      <li class="has-dropdown">
        <a href="account.php">Welcome <?php echo $_SESSION['username']; ?>!</a>
        <ul class="dropdown">
          <?php if ($user->user_has_access()): ?>
            <li><a href="control_panel.php">Control Panel</a></li>
          <?php endif; ?>
          <li><a href="account.php">My Account</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>

    <?php else: ?>
    <ul class="right">
      <li class="right"><a href="register.php">Register</a></li>
      <li class="divider right"></li>
      <li class="has-form">
        <div class="row collapse">
          <form method="POST" class="row collapse">
            <div class="small-4 columns">
              <input type="text" placeholder="Username" name="username" required/>
            </div>
            <div class="small-4 columns">
              <input type="password" placeholder="Password" name="password" required/>
            </div>
            <div class="small-4 columns">
              <button class="success button expand" type="submit" name="login">Login</button>
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