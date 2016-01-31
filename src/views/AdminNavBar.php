<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <h1><a href="/">Example Site</a></h1>
        </li>
        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>

    <section class="top-bar-section">
        <ul class="right">
            <li class="has-dropdown">
                <a href="Account">Welcome <?php echo $_SESSION['username']; ?>!</a>
                <ul class="dropdown">
                    <li><a href="controlPanel">Control Panel</a></li>
                    <li><a href="Account">My Account</a></li>
                    <li><a href="Logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </section>
</nav>

<div class="row">
    <div>&nbsp;</div>
</div>
