<?php include "databaseFunctions.php";
session_start(); 

if(!isset($_SESSION['user_id'])) {
    header('Location: loginRequired.php');
}

date_default_timezone_set("America/Edmonton");

$sql = "SELECT username FROM users WHERE user_id = {$_SESSION['user_id']}";

if($result = db_select($sql)) {
	$message = "Welcome, " . $result[0]['username'] . "!";
} else {
	$message = "Welcome, could not find username...";
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">

	<!-- jQuery  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body class="wrapper">

	<h1><img id="logo" src="../images/logo.gif">Home</h1>
	<div id="topRightNav">
		<a href="logout.php" class="loginButton">Logout</a>
	</div>

	<div id="mainNav">
		<ul>
			<li class="active"><a href="home.php">Home</a></li>
			<li><a href="#">Calendar</a></li>
			<li>
				<a>Manage Volunteers</a>
				<ul class="dropdown">
					<li><a href="newVolunteer.php">New Volunteer</a></li>
					<li><a href="updateVolunteer.php">Update Volunteer</a></li>
					<li><a href="#">Update Time Entries</a></li>
				</ul>
			</li>
			<li><a href="#">Reports</a></li>
		</ul>
	</div>

	<div class="container main">
		<h2><?php echo $message ?></h2>

		<p><?php echo "The date is " . date("Y/m/d") . "<br>";?></p>
		<p><?php echo "The time is " . date("h:i:sa"); ?></p>
		
		<h3>Site Map</h3>
		<ul>
			<li>Admin Functions
				<ul>
					<li><a href="login.php">Admin Login</a></li>
					<li><a href="addUser.php">Add Admin User</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
			<li>Manage Volunteers 
				<ul>
					<li><a href="newVolunteer.php">New Volunteer</a></li>
					<li><a href="updateVolunteer.php">Update Volunteer</a></li>
				</ul>
			</li>
			<li><a href="#">Help</a></li>
		</ul>

		<small>Kodiak Softworks 2017</small>			
	</div>
</body>
</html>