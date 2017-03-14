<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php/formValidation.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		createVolunteer();
	}

	function createVolunteer() {
		if(volunteerExists()) {
			return db_error();
		} 

		if ($volunteerId = makeVolunteerRecord()) {
			makePrefAvailRecord($volunteerId);
			makePrefDeptRecord($volunteerId);

			if($emergencyContactId = emergencyContactExists()) {
				//Emergency contact already exists
				joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
			} else {
				//Emergency contact does not already exists
				$emergencyContactId = makeEmergencyContactRecord();
				joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
			}
		} else {
			//Volunteer creation was unsuccessful
			return db_error();
		}
	}

	function volunteerExists() {
		//Check if the volunteer with same name and birthdate already exists in the database
		$firstName = db_quote($_POST['volunteerFirstName']);
		$lastName = db_quote($_POST['volunteerLastName']);
		$birthdate = db_quote($_POST['volunteerDOB']);

		$rows = db_select("SELECT volunteer_id FROM volunteer WHERE volunteer_fname=$firstName AND volunteer_lname=$lastName AND volunteer_birthdate=$birthdate");

		return ($rows) ? true : false; 
	}

	function makeVolunteerRecord() {
		$connection = db_connect();

		$firstName = db_quote($_POST['volunteerFirstName']);
		$lastName = db_quote($_POST['volunteerLastName']);
		$email = db_quote($_POST['volunteerEmail']);
		$birthdate = db_quote($_POST['volunteerDOB']);
		$gender = db_quote($_POST['volunteerGender']);
		$address = db_quote($_POST['volunteerAddress']);
		$city = db_quote($_POST['volunteerCity']);
		$province = db_quote($_POST['province']);
		$postalCode = db_quote($_POST['postalCode']);

		$primaryPhone = regexForPhone($_POST['volunteerPrimaryPhone']);
		$primaryPhone = db_quote($primaryPhone);

		//Secondary phone is not requred
		$secondaryPhone = secondaryPhone();

		//Volunteers are active by default
		$volunteerStatus = true;

		db_query("INSERT INTO volunteer (volunteer_fname, volunteer_lname, volunteer_email, volunteer_birthdate, volunteer_gender, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone, volunteer_secondaryphone, volunteer_status) VALUES ($firstName, $lastName, $email, $birthdate, $gender, $address, $city, $province, $postalCode, $primaryPhone, $secondaryPhone, $volunteerStatus)");

		return newRowId($connection);
	}

	function secondaryPhone() {
		//Secondary phone is not required, so instead of having a blank value...
		if(empty($_POST['volunteerSecondaryPhone'])) {
			return db_quote("None");
		} else {
			$phone = regexForPhone($_POST['volunteerSecondaryPhone']);
			return db_quote($phone);
		}
	}

	function makePrefAvailRecord($volunteerId) {
		$connection = db_connect();
		$daysAndShifts = getPrefAvailFromForm();
		
		foreach($daysAndShifts as $day => $preference) {

			$stmt = $connection->prepare("INSERT INTO pref_avail (volunteer_fk, weekday, am, pm) VALUES (?, ?, ?, ?)");

			$stmt->bind_param("ssss", $volunteerId, $day, $am, $pm);

			$stmt->execute();
		}

		return newRowId($connection);
	}

	function getPrefAvailFromForm() {
		$weekdays = ["monday", "tuesday", "wednesday", "thursday", "friday"];
		$daysAndShifts = array();
		
		foreach ($weekdays as $day) {
			//'yes' or 'no'
			$dayAM = db_quote($_POST[$day . 'AM']);
			$dayPM = db_quote($_POST[$day . 'PM']);

			$daysAndShifts[$day] = ["AM" => $dayAM, "PM" => $dayPM];
		}

		return $daysAndShifts;
	}

	function makePrefDeptRecord($volunteerId) {
		$connection = db_connect();
		$selectedDepartments = getPrefDeptFromForm();

		foreach($selectedDepartments as $department => $preference) {

			$stmt = $connection->prepare("INSERT INTO pref_dept (volunteer_fk, department, allow) VALUES (?, ?, ?)");

			$stmt->bind_param("sss", $volunteerId, $department, $preference);

			$stmy->execute();
		}
		return newRowId($connection);
	}

	function getPrefDeptFromForm() {
		$selectedDepartments = [
			"front" => db_quote($_POST["prefFront"]), 
			"vio" => db_quote($_POST["prefVIO"]),
			"kitchen" => db_quote($_POST["prefKitchen"]),
			"warehouse" => db_quote($_POST["prefWarehouse"])
		];

		return $selectedDepartments;
	}

	function emergencyContactExists() {
		$connection = db_connect();

		$firstName = db_quote($_POST['emergencyFirstName']);
		$lastName = db_quote($_POST['emergencyLastName']);

		$stmt = $connection->prepare("SELECT emergency_contact_id FROM emergency_contact WHERE emergency_contact_fname=? AND emergency_contact_lname=?");

		$stmt->bind_param("ss", $firstName, $lastName);

		$stmt->execute();

		return ($rows) ? $rows[0]['emergency_contact_id'] : false;
	}

	function newRowId($connection) {
		if($connection->error) {
			return false;
		} else {
			//Return the Id of the last created row
			return $connection->insert_id;
		}	
	}

	function makeEmergencyContactRecord() {
		$connection = db_connect();

		$firstName = regexForNames($_POST['emergencyFirstName']);
		$firstName = db_quote($firstName);

		$lastName = regexForNames($_POST['emergencyLastName']);
		$lastName = db_quote($lastName);

		$stmt = $connection->prepare("INSERT INTO emergency_contact (emergency_conact_fname, emergency_contact_lname) VALUES (?, ?)");

		$stmt->bind_param("ss", $firstName, $lastName);

		$stmt->execute();

		return newRowId($connection);
	}

	function joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId) {
		$connection = db_connect();

		$volunteerId = db_quote($volunteerId);
		$emergencyContactId = db_quote($emergencyContactId);

		$relationship = regexForNames($_POST['emergencyRelationship']);
		$relationship = db_quote($relationship);

		$phone = regexForPhone($_POST['emergencyPhone']);
		$phone = db_quote($phone);

		db_query("INSERT INTO jnct_volunteer_emergency_contact (volunteer_fk, emergency_contact_fk, relationship, phone) VALUES ($volunteerId, $emergencyContactId, $relationship, $phone)");

		$stmt = $connection->prepare("INSERT INTO jnct_volunteer_emergency_contact (volunteer_fk, emergency_contact_fk, relationship, phone) VALUES (?, ?, ?, ?)");

		$stmt->bind_param("ssss", $volunteerId, $emergencyContactId, $relationship, $phone);

		$stmt->execute();

		return newRowId($connection);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>New Volunteer PHP</title>
</head>
<body>
<p>New Volunteer PHP Page</p>

</body>
</html>