<div class="row align-center">
	<?php if (isset($_SESSION['error'])): ?>
	<div class="medium-6 text-center">
		<div class="alert callout">
			<?php
			echo $_SESSION['error'];
			unset($_SESSION['error']);
			?>
		</div>
	</div>
	<?php endif ?>

	<?php if (isset($_SESSION['success'])): ?>
	<div class="medium-6 text-center">
		<div class="success callout">
			<?php
			echo $_SESSION['success'];
			unset($_SESSION['success']);
			?>
		</div>
	</div>
	<?php endif ?>
</div>

<div class="row">&nbsp;</div>

<div class="row align-center">
	<div class="small-12 medium-8 large-6 columns">
		<form method="POST">
			<div class="row">
				<div class="small-12 columns">
					<input type="text" placeholder="Username" name="username" maxlength="20">
				</div>
				<div class="small-12 columns">
					<input type="password" placeholder="Password" name="password" maxlength="20">
				</div>
				<div class="small-12 columns">
					<input type="password" placeholder="Confirm Password" name="password_confirm" maxlength="20"/>
				</div>
				<div class="small-12 columns">
					<input type="text" placeholder="First Name" name="first_name" maxlength="20">
				</div>
				<div class="small-12 columns">
					<input type="text" placeholder="Last Name" name="last_name" maxlength="20">
				</div>
				<div class="small-12 columns">
					<input class="button" type="submit" name="register_user" value="Register">
				</div>
			</div>
		</form>
	</div>
</div>
