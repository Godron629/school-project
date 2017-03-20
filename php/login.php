<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>

<?php 
session_start(); 
if(isset($_SESSION['user_id'])) {
	die("<div id='loginBox' class='container centerAlign'>You are already logged in, do you want to <a href='logout.php'>Log Out?</a>");
} 
?>

<body>
<div id="loginBox" class="container centerAlign">
	<img id="loginLogo" src="../images/logo.gif">
	<h2>Admin Login</h2>
	<form class="loginButtons" action="login_submit.php" method="post">
		<fieldset>
		<p>
		<label for="username">Username</label>
		<input type="text" id="username" name="username" value="" maxlength="20" />
		</p>

		<p>
		<label for="password">Password</label>
		<input type="password" id="password" name="password" value="" maxlength="20" />
		</p>

		<p>
		<input type="submit" value="Login" />
		</p>
		</fieldset>
	</form>
</div>
</body>
</html>

