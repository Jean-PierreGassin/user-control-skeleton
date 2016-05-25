<form method="POST" class="large-4 large-centered columns">
	<div class="large-12 columns">
		<input disabled type="text" value="<?php echo $message['user'] ?> " name="username" maxlength="20"/>
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
		<input type="password" name="new_pass" maxlength="20"/>
	</div>
	<div class="small-6 columns">
		Confirm Password:<br/>
		<input type="password" name="confirm_pass" maxlength="20"/>
	</div>
	<div class="small-6 columns">
		<input type="password" placeholder="Current Password" name="db_pass" maxlength="20" required/>
	</div>
	<div class="small-6 columns">
		<button class="postfix" type="submit" name="update_user">Update</button>
	</div>
</form>
