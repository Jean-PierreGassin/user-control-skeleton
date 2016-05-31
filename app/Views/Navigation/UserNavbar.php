<div class="top-bar">
	<div class="top-bar-title">
		<span data-responsive-toggle="responsive-menu" data-hide-for="medium">
			<button class="menu-icon dark" type="button" data-toggle></button>
		</span>
		<strong><a href="/">User Control Skeleton</a></strong>
	</div>
	<div id="responsive-menu">
		<div class="top-bar-right">
			<ul class="dropdown menu" data-dropdown-menu>
				<li>
					<a href="Account">Welcome <?php echo $_SESSION['username']; ?>!</a>
					<ul class="menu vertical">
						<li><a href="Account">My Account</a></li>
						<li><a href="Logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div>&nbsp;</div>
</div>
