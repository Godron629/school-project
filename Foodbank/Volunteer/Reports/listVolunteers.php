<?php
	$servername = "localhost";
	$username = "root";
	//$password = "55stayAlive";
	$password = "";
	//$dbname = "kodiak";
	$dbname = "foodbank";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}
?>

<html>
	<head>
		<title>List Volunteers</title>
		<link rel="stylesheet" href="reports.css">
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<script type="text/javascript">
			//Populate table with more options on checkbox change
			$(document).ready(function() {
				$("#moreOptionsCheckbox").change(function() {
					$(".moreOptions").toggleClass("hideColumn", !this.checked);
				}).change();
			});
		</script>
	</head>

	<div id="header">
		<h2>LIST OF VOLUNTEERS</h2>
	</div>

	<div id="header2">
		<h4>DATE OF REPORT: <?php echo date("l, F jS, Y") . "<br>"; ?> </h4>
	</div>
	
	<div id="option">
		<p class="inlineParagraph">More Options</p> 
		<input type='checkbox' id='moreOptionsCheckbox'>
	</div>
	
	 <?php

		//Display table with volunteer row data
		$sql = "select * from volunteer";

		$result = $conn->query($sql);

		if(!$result) {
			echo "error" . $conn->error . "<br/>";
			die("Database Error: Call Brayden");
		}
		
		echo "<table id='volunteerTable'>";
		echo "
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Status</th>
				
				<th class='moreOptions'>DOB</th>
				<th class='moreOptions'>Gender</th>
				<th class='moreOptions'>Phone</th>
				<th class='moreOptions'>Email</th>
			</tr>
		";
		
		while($row = $result->fetch_assoc()) {
			$firstName = $row['volunteer_fname'];
			$lastName = $row['volunteer_lname'];
			$volunteerId = $row['volunteer_id'];
			$status = $row['volunteer_status'];
			$birthdate = $row['volunteer_birthdate'];
			$gender = $row['volunteer_gender'];
			$primaryPhone = $row['volunteer_primaryphone'];
			$email = $row['volunteer_email'];
			
			if ($status == TRUE){
				$status = 'Active';
			} else {
				$status = 'Not Active';
			};
			
			echo "
			<tr>
				<td> 
					<a href='vIndiInfo.php?id=$volunteerId'>$volunteerId</a>
				</td>
				<td>$firstName</td>
				<td>$lastName</td>
				<td>$status</td>
				<td class='moreOptions'>$birthdate</td>
				<td class='moreOptions'>$gender</td>
				<td class='moreOptions'>$primaryPhone</td>
				<td class='moreOptions'>$email</td>
			</tr>";	
		}
		
		echo "</table>";

		$conn->close();
	?>
</html>