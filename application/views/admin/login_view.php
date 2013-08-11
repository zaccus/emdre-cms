	<div id="login">
		<form action="<?php echo base_url() ?>login/process" method="post">
			<label for="username">Username:</label>
			<input id="login_username" name="username" />
			
			<label for="password">Password:</label>
			<input type="password" id="login_password" name="password" />
			<input type="submit" value="Log In" />
		</form>
	</div>
