<!DOCTYPE html>
<html>
<head>
	<title>Login Required</title>
	<link rel="stylesheet" type="text/css" href="/Foodbank/css/stylesheet.css">
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
</head>
<body class="Loginwrapper">
	<div id="loginBox" class="container centerAlign">
		<p>You must be logged in to see that page.</p>
		
		<a href="#" onclick="goBack()" class="loginButton">Back</a>
		<a href="/Foodbank/login.php" class="loginButton">Login</a>
	</div>
</body>
</html>