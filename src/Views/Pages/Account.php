<form method="POST" class="large-4 large-centered columns">
	<div class="large-12 columns">
		<input readonly type="text" value="<?php echo $message['user'] ?> " name="username" maxlength="20"/>
	</div>
	<div class="small-12 columns">
		First name:<br/>
		<input type="text" value="<?php echo $message['first_name']  ?>" name="first_name" maxlength="20"/>
	</div>
	<div class="small-12 columns">
		Last name:<br/>
		<input type="text" value="<?php echo $message['last_name'] ?>" name="last_name" maxlength="20"/>
	</div>
	<div class="small-6 columns">
		New Password:<br/>
		<input type="password" name="new_password" maxlength="20"/>
	</div>
	<div class="small-6 columns">
		Confirm Password:<br/>
		<input type="password" name="password_confirm" maxlength="20"/>
	</div>
	<div class="small-6 columns">
		<input type="password" placeholder="Current Password" name="current_password" maxlength="20" required/>
	</div>
	<div class="small-6 columns">
		<button class="postfix" type="submit" name="update_user">Update</button>
	</div>
</form>
