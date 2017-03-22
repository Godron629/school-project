<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</head>

<?php 
session_start(); 
if(isset($_SESSION['user_id'])) {
	die("<div id='loginBox' class='container centerAlign'>You are already logged in, do you want to <a href='/Foodbank/Admin/logout.php'>Log Out?</a>");
} 
?>

<body class="Loginwrapper">
<div id="loginBox" class="centerAlign">
		<div id="topRightNav">
		<a href="/Foodbank/TimeClock/index.php">Time Clock</a>
	</div>
	<a href="/Foodbank/"><img id="loginLogo" src="images/logo.gif"></a>
	<h2>Admin Login</h2><br>
	<form class="loginButtons" action="/Foodbank/Admin/login_submit.php" method="post">
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

