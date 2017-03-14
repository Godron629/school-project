<?php 
	
	$iFrame = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['reportType'])) {
			$iFrame = $_POST['reportType'];
		}
	}
?>

<html>
	<head>
		<title>Reports</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
		<link rel="stylesheet" type="text/css" href="reports.css">
	</head>
	
	<body class="wrapper">
		<h1><img id="logo" src="logo.gif">Reports</h1>
		<div id="topRightNav">
			<a href="#">Time Clock</a>
			<a href="#">Logout</a>
		</div>

		<nav>
			<ul>
				<li><a href="#">Calendar</a></li>
				<li>
					<a>Manage Volunteers</a>
					<ul class="dropdown">
						<li><a href="#">New Volunteer</a></li>
						<li><a href="#">Update Volunteer Information</a></li>
						<li><a href="#">Update Time Entries</a></li>
					</ul>
				</li>
				<li><a class="active" href="reports.php">Reports</a></li>
			</ul>
		</nav>

		<div class="container">
			<form id="selectReport" action="" method="POST">
			<!-- TODO: Finish these reports -->
				<select id="reportType" name="reportType">
					<option value="" disabled selected>Select a Report to Generate</option>
					<option value="listVolunteers.php">List Volunteers</option>
					<option value="report2">Currently clocked-In</option>
					<option value="report3">Calendar</option>
				</select>
				<input type="Submit" value="Generate Report">
			</form>
		</div>
		
		<div id="reportsFrame">
			<iframe src="<?php echo $iFrame; ?>" >
				<p>Your browser does not support iframes.</p>
			</iframe>
		</div>
	</body>
</html>