<?php
session_start();

session_unset();

session_destroy();
?>

<html>
<head>
	<title>Logged Out</title>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>

<body>
	<a href="login.php">Login</a>
	<div id="loginBox" class="container centerAlign">
		<p>You have been logged out.</p>
		<a href="http://www.google.com" class="loginButton">Leave</a>
		<a href="login.php" class="loginButton">Login</a>
	</div>
</body>
</htl>