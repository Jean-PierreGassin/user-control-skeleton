<?php

class generate_view
{
	public static function new_view($view)
	{
		switch($view)
		{
			case('unauthorized'):
				echo '
				<div class="row">
					<div class="large-12 columns">
				      <div class="large-12 large-centered text-center columns">
				        <div class="alert-box alert">ERROR: Unauthorized!</div>
				      </div>
					</div>
				</div>
		        ';
		        break;

			case('wrong_pass'):
				echo '
				<div class="row">
					<div class="large-12 columns">
				      <div class="large-4 large-centered text-center columns">
				        <div class="alert-box alert">Incorrect Password!</div>
				      </div>
					</div>
				</div>
		        ';
		        break;

			case('pass_mismatch'):
				echo '
				<div class="row">
					<div class="large-12 columns">
				      <div class="large-4 large-centered text-center columns">
				        <div class="alert-box alert">Passwords do not match.</div>
				      </div>
					</div>
				</div>
		        ';
		        break;

			case('user_exists'):
				echo '
				<div class="row">
					<div class="large-12 columns">
				      <div class="large-4 large-centered text-center columns">
				        <div class="alert-box alert">Username already exists.</div>
				      </div>
					</div>
				</div>
		        ';
		        break;

			case('update_success'):
				echo '
				<div class="row">
					<div class="large-12 columns">
				      <div class="large-4 large-centered text-center columns">
				        <div class="alert-box success">Successfully updated information.</div>
				      </div>
					</div>
				</div>
		        ';
		        break;

			case('open_table'):
				echo '
		        <div class="large-12 columns">
		        <table class="large-12">
		        ';
		        break;

			case('open_table_head'):
				echo '
		        <thead>
		        <tr>
		        ';
		        break;

			case('close_table_head'):
				echo '
				</thead>
				</tr>
		        ';
		        break;

			case('close_table'):
				echo '
		        </table>
		        ';
		        break;
		}
	}

	public static function new_view_array($view,$data)
	{
		switch($view)
		{
			case('user_table_headings'):
				foreach ($data as $heading)
				{
				echo '
	            <td>' . $heading['Field'] . '</td>
		        ';
				}
		        break;

			case('user_table_cells'):
		        foreach ($data as $item)
		        {
					echo '<td>' . $item . '</td>';
				}
				echo '</tr>';
		        break;

			case('update_page'):
				echo '
		        <form method="POST" class="large-4 large-centered columns">
		          <div class="large-12 columns">
		            <input disabled type="text" value="' . $data['user'] . '" name="username" maxlength="20"/>
		          </div>
		          <div class="small-12 columns">
		          	First name:<br/>
		            <input type="text" value="' . $data['first_name'] . '" name="first_name" maxlength="20"/>
		          </div>
		          <div class="small-12 columns">
		          	Last name:<br/>
		            <input type="text" value="' . $data['last_name'] . '" name="last_name" maxlength="20"/>
		          </div>
		          <div class="small-6 columns">
		          	New Password (Optional):<br/>
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
		        ';	
		        break;
		}

	}
}

?>