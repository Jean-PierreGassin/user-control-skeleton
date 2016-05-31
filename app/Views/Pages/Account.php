<div class="row align-center">
	<form method="POST" class="small-12 medium-8 large-6 columns">
		<div class="row">
			<div class="small-12 columns">
				<input readonly type="text" value="<?php echo $message['user'] ?>" name="username" maxlength="20">
				<label>First name:
					<input type="text" value="<?php echo $message['first_name']  ?>" name="first_name" maxlength="20">
				</label>
				<label>Last name:
					<input type="text" value="<?php echo $message['last_name'] ?>" name="last_name" maxlength="20">
				</label>
			</div>
			<div class="small-6 columns">
				<label>New Password:
					<input type="password" name="new_password" maxlength="20">
				</label>
			</div>
			<div class="small-6 columns">
				<label>Confirm Password:
					<input type="password" name="password_confirm" maxlength="20">
				</label>
			</div>
			<div class="small-12 columns">
				<input type="password" placeholder="Current Password" name="current_password" maxlength="20" required>
				<button class="button" type="submit" name="update_user">Update</button>
			</div>
		</div>
	</form>
</div>
