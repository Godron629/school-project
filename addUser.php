<?php
	session_start();

	$form_token = md5(uniqid('auth', true));

	$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
	<title>Add User</title>
</head>

<body>
	<h2>Add User</h2>
	<form action="adduser_submit.php" method="post">
		<fieldset>
			<p>
			<label for="phpro_username">Username</label>
			<input type="text" id="phpro_username" name="phpro_username" value="" maxlength="20" />
			</p>

			<p>
			<label for="phpro_password">Password</label>
			<input type="password" id="phpro_password" name="phpro_password" value="" maxlength="20" />
			</p>

			<p>
			<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
			<input type="submit" />
			</p>
			</fieldset>
		</form>
	</body>
</html>