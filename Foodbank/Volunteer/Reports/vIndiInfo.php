<?php
	$servername = "localhost";
	$username = "root";
	//$password = "55stayAlive";
	$password = "";
	//$dbname = "kodiak";
	$dbname = "foodbank";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if($conn->connect_error) {
		die("Connection failed: ". $conn->connect_error);
	}

	$volunteerId = $_GET['id'];
	
	$sql = "SELECT 
			volunteer_id, 
			volunteer_fname, 
			volunteer_lname, 
			volunteer_email, 
			volunteer_gender, 
			volunteer_birthdate, 
			volunteer_street, 
			volunteer_city, 
			volunteer_province, 
			volunteer_postcode, 
			volunteer_primaryphone, 
			volunteer_secondaryphone, 
			volunteer_status, 
			emergency_contact_fname, 
			emergency_contact_lname, 
			phone, 
			relationship
		FROM jnct_volunteer_emergency_contact
		JOIN volunteer ON volunteer.volunteer_id = jnct_volunteer_emergency_contact.volunteer_fk 
		JOIN emergency_contact ON emergency_contact.emergency_contact_id = jnct_volunteer_emergency_contact.emergency_contact_fk
		WHERE volunteer_id='$volunteerId'";

	$result = $conn->query($sql);
		
	if($result) {
		
		$row =$result->fetch_assoc();
		
		$volunteer_id = $row['volunteer_id'];
		$volunteer_fname = $row['volunteer_fname'];
		$volunteer_lname = $row['volunteer_lname'];
		$volunteer_email = $row['volunteer_email'];
		$volunteer_gender = $row['volunteer_gender'];
		$volunteer_birthdate = $row['volunteer_birthdate'];
		$volunteer_street = $row['volunteer_street'];
		$volunteer_city = $row['volunteer_city'];
		$volunteer_province = $row['volunteer_province'];
		$volunteer_postcode = $row['volunteer_postcode'];
		$volunteer_primaryphone = $row['volunteer_primaryphone'];
		$volunteer_secondaryphone = $row['volunteer_secondaryphone'];
		$volunteer_status = $row['volunteer_status'];
		
		$emergency_contact_fname = $row['emergency_contact_fname'];
		$emergency_contact_lname = $row['emergency_contact_lname'];
		$phone = $row['phone'];
	}

	function listDepartments($volunteerId, $conn){
		//Echos columns with department data 
		$sql ="SELECT department FROM pref_dept WHERE volunteer_fk='$volunteerId'";
		$result = $conn->query($sql);
		
		if ($result) {
			while ($row =$result->fetch_assoc()){
				echo $row['department'] . ', ';
			} 
		}
	}

	function listAvailiability($volunteerId, $conn, $day){
		//Echos columns with availiability data
		$sql ="SELECT am, pm FROM pref_avail WHERE volunteer_fk='$volunteerId' AND weekday='$day'";
		$result = $conn->query($sql);
		
		if ($result){
			$row =$result->fetch_assoc(); 
			foreach ($row as $time) {
				echo "<td>$time</td>";
			}
		}
	}
?>

<html>
	<head>
		<title>Contact Card</title>
		<link rel="stylesheet" type="text/css" href="reports.css">
	</head>

	<div id="header">
		<h2>CONTACT CARD</h2>
	</div>

	<div id="header2">
		<h4 id="date">DATE OF REPORT: <?php echo date("l, F jS, Y") . "<br>"; ?> </h4>
	</div>

	<table>
	  <tr>
		<td><div class="bold">Volunteer's Name:</div></td><td><?php echo $volunteer_fname .' '. $volunteer_lname ?></td>
		<td><div class="bold">Availability</div>
		<td><div class="bold">AM</td></div>
		<td><div class="bold">PM</td>
	  </tr>
	  <tr>
		<td>ID:</td><td><?php echo $volunteer_id ?></td>
		<td>Monday</td>
		<?php listAvailiability($volunteerId, $conn, 'monday'); ?>
	  </tr>
	  <tr>
		<td>Date of Birth:</td>
		<td><?php echo $volunteer_birthdate?></td>
		<td> Tuesday</td>
		<?php listAvailiability($volunteerId, $conn, 'tuesday') ?>
	  </tr>
	  <tr>
		<td>Gender:</td>
		<td><?php echo $volunteer_gender ?></td>
		<td> Wednesday</td>
		<?php listAvailiability($volunteerId, $conn, 'wednesday') ?>
	  </tr>
	  <tr>
		<td>Email:</td>
		<td><?php echo $volunteer_email ?></td>
		<td> Thursday</td>
		<?php listAvailiability($volunteerId, $conn, 'thursday') ?>
	  </tr>
	  <tr>
		<td>Phone:</td>
		<td><?php echo $volunteer_primaryphone ?></td>
		<td> Friday</td>
		<?php listAvailiability($volunteerId, $conn, 'friday') ?>
	  </tr>
	  <tr>
		<td>Secondary Phone:</td>
		<td>
		<?php echo $volunteer_secondaryphone ?>
	  </tr>
	  <tr>
		<td>Province:</td>
		<td>
		<?php echo $volunteer_province ?></td>
		<td> Preferred Department(s):</td>
		<td><?php listDepartments($volunteerId, $conn) ?></td>
	  </tr>
	  <tr>
		<td>Postal Code:</td>
		<td><?php echo $volunteer_postcode ?></td>
	  </tr>
	  <tr>
		<td><div class="bold">Emergency Contact:</div></td>
		<td><?php echo $emergency_contact_fname .' '. $emergency_contact_lname?></td>
	  </tr>
	  <tr>
		<td>Phone:</td>
		<td><?php echo $phone?></td>
	  </tr>
	</table>

	<a class='link' href="listVolunteers.php">Previous Page</a>
</html>