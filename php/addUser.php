<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: loginRequired.php');
}

$form_token = md5(uniqid('auth', true));

$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
	<title>Add User</title>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>

<body>
<a href="login.php">Login</a>
<div id="loginBox" class="container centerAlign">
	<h2>Add User</h2>
	<form action="addUser_submit.php" class="loginButtons" method="post">
		<fieldset>
		<p>
		<label for="username">Username</label>
		<input type="text" id="username" name="username" value="" maxlength="20">
		</p>

		<p>
		<label for="password">Password</label>
		<input type="text" id="password" name="password" value="" maxlength="20">
		</p>

		<p>
		<input type="hidden" name="form_token" value="<?php echo $form_token; ?>">
		<input type="submit">
		</p>
		</fieldset>
	</form>
</div>
</body>
</html>