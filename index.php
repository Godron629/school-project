<!DOCTYPE html> <!-- Gideon Richter 2/22/2017 -->
<html>
<head>
	<title>New Volunteer</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</head>
<body class="wrapper">

<h1><img id="logo" src="images/logo.gif">New Volunteer</h1>
<div id="topRightNav">
	<a href="#">Time Clock</a>
	<a href="#">Logout</a>
</div>

<div id="mainNav">
	<ul>
		<li><a href="#">Calendar</a></li>
		<li>
			<a class="active">Manage Volunteers</a>
			<ul class="dropdown">
				<li><a href="#">New Volunteer</a></li>
				<li><a href="#">Update Volunteer Information</a></li>
				<li><a href="#">Update Time Entries</a></li>
			</ul>
		</li>
		<li><a href="#">Reports</a></li>
	</ul>
</div>

<div class="container main">
	<div class="container leftSide blockLabels marginBottomTextBox" id="volunteerInformation">
		<h2>Volunteer Information</h2>
		<form action="myPHPFiles/createNewVolunteer.php" method="POST">
			<div id="volunteerInformationColumn1">
				<label for="volunteerFirstName">First Name:</label>
				<input id="volunteerFirstName" type="text" name="volunteerFirstName" required>

				<label for="volunteerLastName">Last Name:</label>
				<input id="volunteerLastName" type="text" name="volunteerLastName" required>

				<label for="volunteerEmail">Email:</label>
				<input id="volunteerEmail" type="email" placeholder="example@email.com" name="volunteerEmail" required>

				<label for="volunteerDOB">Date of Birth:</label>
				<input type="date" name="volunteerDOB" required>

				<label id="volunteerGender">Gender:</label>
				<select id="volunteerGender" name="volunteerGender" required>
					<option value="" disabled selected>Select Gender...</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
					<option value="other">Other</option>
				</select>

				<label for="volunteerAddress">Address:</label>
				<input id="volunteerAddress" type="text" name="volunteerAddress" required>
			</div>

			<div id="volunteerInformationColumn2">
				<label for="volunteerCity">City:</label>
				<input id="volunteerCity" type="text" name="volunteerCity" required>

				<label for="province">Province:</label>
				<select id="province" name="province" required>
					<option value="" disabled selected>Select Province...</option>
					<option value="AB">Alberta</option>
					<option value="BC">British Columbia</option>
					<option value="MB">Manitoba</option>
					<option value="NB">New Brunswick</option>
					<option value="NL">Newfoundland and Labrador</option>
					<option value="NS">Nova Scotia</option>
					<option value="ON">Ontario</option>
					<option value="PE">Prince Edward Island</option>
					<option value="QC">Quebec</option>
					<option value="SK">Saskatchewan</option>
					<option value="NT">Northwest Territories</option>
					<option value="NU">Nunavut</option>
					<option value="YT">Yukon</option>
				</select>	

				<label for="postalCode">Postal Code:</label>
				<input id="postalCode" type="text" pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]" placeholder="Ex. A0A 0A0" name="postalCode" required>

				<label for="volunteerPrimaryPhone">Primary Phone:</label>
				<input id="volunteerPrimaryPhone" type="text" placeholder="(123) 456-7890" 
					name="volunteerPrimaryPhone" required>

				<label for="volunteerSecondaryPhone">Secondary Phone: <br><small>*Not Required</small></label>
				<input id="volunteerSecondaryPhone" type="text" placeholder="(123) 456-7890" name="volunteerSecondaryPhone">
			</div>
	</div>

	<div class="container rightSide blockCheckboxLabels" id="preferredTimes">
		<div  class="container" id="preferredTimesColumn2">
			<h2>Preferred Times</h2>
			<p>(AM) / (PM)</p>
			<ul class="checkboxList">
				<li>
					<label for="mondayCheckAM">Monday:</label>
					<input hidden checked type="checkbox" name="mondayAM" value="no">
					<input hidden checked type="checkbox" name="mondayPM" value="no">
					<input id="mondayCheckAM" type="checkbox" name="mondayAM" value="yes">
					<input id="mondayCheckPM" type="checkbox" name="mondayPM" value="yes">
				</li>
				<li>
					<label for="tuesdayCheckAM">Tuesday:</label>
					<input hidden checked type="checkbox" name="tuesdayAM" value="no">
					<input hidden checked type="checkbox" name="tuesdayPM" value="no">
					<input id="tuesdayCheckAM" type="checkbox" name="tuesdayAM" value="yes">
					<input id="tuesdayCheckPM" type="checkbox" name="tuesdayPM" value="yes">
				</li>
				<li>
					<label for="wednesdayCheckAM">Wednesday:</label>
					<input hidden checked type="checkbox" name="wednesdayAM" value="no">
					<input hidden checked type="checkbox" name="wednesdayPM" value="no">
					<input id="wednesdayCheckAM" type="checkbox" name="wednesdayAM" value="yes">
					<input id="wednesdayCheckPM" type="checkbox" name="wednesdayPM" value="yes">
				</li>
				<li>
					<label for="thursdayCheckAM">Thursday:</label>
					<input hidden checked type="checkbox" name="thursdayAM" value="no">
					<input hidden checked type="checkbox" name="thursdayPM" value="no">
					<input id="thursdayCheckAM" type="checkbox" name="thursdayAM" value="yes">
					<input id="thursdayCheckPM" type="checkbox" name="thursdayPM" value="yes">
				</li>
				<li>
					<label for="fridayCheckAM">Friday:</label>
					<input hidden checked type="checkbox" name="fridayAM" value="no">
					<input hidden checked type="checkbox" name="fridayPM" value="no">
					<input id="fridayCheckAM" type="checkbox" name="fridayAM" value="yes">
					<input id="fridayCheckPM" type="checkbox" name="fridayPM" value="yes">
				</li>
			</ul>
		</div>
	</div>

	<div class="container leftSideBottom blockLabels marginBottomTextBox" id="emergencyContact">
		<h2>Emergency Contact</h2>
		<label>First Name:</label>
		<input id="emergencyFirstName" type="text" name="emergencyFirstName" required>

		<label>Last Name:</label>
		<input id="emergencyLastName" type="text" name="emergencyLastName" required>

		<label>Relationship:</label>
		<select id="emergencyRelationship" name="emergencyRelationship" required>
			<option disabled selected value="" >Select Relationship</option>
		  	<option value="Aunt">Aunt</option>
			<option value="Brother">Brother</option>
			<option value="">Caretaker</option>
			<option value="Daughter">Daughter</option>
			<option value="Doctor">Doctor</option>
			<option value="Emergency Services">Emergency Services</option>
			<option value="Father">Father</option>
			<option value="Friend">Friend</option>
			<option value="Grandfather">Grandfather</option>
			<option value="Grandmother">Grandmother</option>
			<option value="Husband">Husband</option>
			<option value="In-law">In-law</option>
			<option value="Mother">Mother</option>
			<option value="Nurse">Nurse</option>
			<option value="Other">Other</option>
			<option value="Parole Officer">Parole Officer</option>
			<option value="Significant Other">Significant Other</option>
			<option value="Sister">Sister</option>
			<option value="Son">Son</option>
			<option value="Teacher">Teacher</option>
			<option value="Uncle">Uncle</option>
			<option value="Unknown">Unknown</option>
			<option value="Wife">Wife</option>
		</select>

		<label>Phone:</label>
		<input id="emergencyPhone" type="text" placeholder="(123) 456-7890" name="emergencyPhone" required>
	</div>

	<div class="container rightSideBottom blockCheckboxLabels" id="preferredDepartments">
		<div class="container" id="preferredDepartmentsColumn2">
			<h2>Preferred Department</h2>
			<ul class="checkboxList">
				<li>
					<label for="frontCheck">Front:</label>
					<input hidden checked type="checkbox" name="prefFront" value="no">
					<input id="frontCheck" type="checkbox" name="prefFront" value="yes">
				</li>
				<li>
					<label for="volunteerIntakeCheck">Volunteer Intake Coordinator:</label>
					<input hidden checked type="checkbox" name="prefVIO" value="no">
					<input id="volunteerCheck" type="checkbox" name="prefVIO" value="yes">
				</li>
				<li>	
					<label for="kitchenCheck">Kitchen:</label>
					<input hidden checked type="checkbox" name="prefKitchen" value="no">
					<input id="kitchenCheck" type="checkbox" name="prefKitchen" value="yes">
				</li>
				<li>
					<label for="warehouseCheck">Warehouse:</label>
					<input hidden checked type="checkbox" name="prefWarehouse" value="no">
					<input id="warehouseCheck" type="checkbox" name="prefWarehouse" value="yes">
				</li>
			</ul>
		</div>
	</div>
	<div class="container bigButtons" id="submitButtons">
		<a href="index.php"><button type="button">Cancel</button></a>
		<input type="submit" name="submitVolunteer">
	</div>
	</form>
</div>

</body>
</html>