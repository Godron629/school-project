<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";
include $_SERVER['DOCUMENT_ROOT'] . "/php/formValidation.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	createVolunteer();
}

function createVolunteer() {
	if(volunteerExists()) {
		die("Error: Volunteer already exists");
	} 

	//If successful, makeVolunteerRow returns new row Id, making this true
	if ($volunteerId = makeVolunteerRow()) {
		makePrefAvailRow($volunteerId);
		makePrefDeptRow($volunteerId);

		if($emergencyContactId = emergencyContactExists()) {
			//Emergency Contact already exists, so link them to volunteer
			joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
		} else {
			//Emergency Contact does not exist, so make them, then link
			$emergencyContactId = makeEmergencyContactRow();
			joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
		}
	} else {
		die("Error: Volunteer record creation unsuccessful: " . db_error());
	}
}

function volunteerExists() {
	$firstName = regexForNames($_POST['volunteerFirstName']);
	$firstName = db_quote($firstName);
	$lastName = regexForNames($_POST['volunteerLastName']);
	$lastName = db_quote($lastName);
	$birthdate = db_quote($_POST['volunteerDOB']);

	$rows = db_select("SELECT volunteer_id FROM volunteer WHERE volunteer_fname={$firstName}
	 AND volunteer_lname={$lastName} AND volunteer_birthdate={$birthdate}");

	return ($rows) ? true : false; 
}

function makeVolunteerRow() {
	$connection = db_connect();

	$firstName = regexForNames($_POST['volunteerFirstName']);
	$firstName = db_quote($firstName);

	$lastName = regexForNames($_POST['volunteerLastName']);
	$lastName = db_quote($lastName);

	$email = db_quote($_POST['volunteerEmail']);
	$birthdate = db_quote($_POST['volunteerDOB']);
	$gender = db_quote($_POST['volunteerGender']);

	$address = regexForNames($_POST['volunteerAddress']);
	$address = db_quote($address);

	$city = regexForNames($_POST['volunteerCity']);
	$city = db_quote($city);

	$province = db_quote($_POST['province']);
	$postalCode = db_quote($_POST['postalCode']);

	$primaryPhone = regexForPhone($_POST['volunteerPrimaryPhone']);
	$primaryPhone = db_quote($primaryPhone);

	$secondaryPhone = secondaryPhone();

	//Volunteers are active by default
	$volunteerStatus = true;

	db_query("INSERT INTO volunteer (volunteer_fname, volunteer_lname, volunteer_email, volunteer_birthdate, volunteer_gender, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone, volunteer_secondaryphone, volunteer_status) VALUES ($firstName, $lastName, $email, $birthdate, $gender, $address, $city, $province, $postalCode, $primaryPhone, $secondaryPhone, $volunteerStatus)");

	return newRowId($connection);
}

	function secondaryPhone() {
		//Secondary phone is not required, so if nothing is entered...
	if(empty($_POST['volunteerSecondaryPhone'])) {
		return db_quote("None");
	} else {
		$phone = regexForPhone($_POST['volunteerSecondaryPhone']);
		return db_quote($phone);
	}
}

function makePrefAvailRow($volunteerId) {
	$connection = db_connect();
	$daysAndShifts = getPrefAvailFromForm();
	
	//Insert the values of the checkboxes for each day
	foreach($daysAndShifts as $day => $preference) {
		$preferenceAM = $preference['AM'];
		$preferencePM = $preference['PM'];

		db_query("INSERT INTO pref_avail (volunteer_fk, weekday, am, pm) VALUES ($volunteerId, '$day', $preferenceAM, $preferencePM)");
	}

	return newRowId($connection);
}

function getPrefAvailFromForm() {
	$weekdays = ["monday", "tuesday", "wednesday", "thursday", "friday"];
	$daysAndShifts = array();

	//Get the value of each preferred availiability checkbox: $dayAM = 'yes' or 'no'
	foreach ($weekdays as $day) {
		$dayAM = db_quote($_POST[$day . "AM"]);
		$dayPM = db_quote($_POST[$day . "PM"]);

		$daysAndShifts[$day] = ["AM" => $dayAM, "PM" => $dayPM];
	}

	return $daysAndShifts;
}

function makePrefDeptRow($volunteerId) {
	$connection = db_connect();
	$preferredDepartments = getPrefDeptFromForm();

	foreach($preferredDepartments as $department => $preference) {
		db_query("INSERT INTO pref_dept (volunteer_fk, department, allow) VALUES ($volunteerId, '{$department}', {$preference})");
	}

	return newRowId($connection);
}

function getPrefDeptFromForm() {
	$connection = db_connect();

	//Get value (preference) of each department checkbox: 'yes' or 'no'
	$preferredDepartments = [
		"front" => db_quote($_POST["prefFront"]), 
		"vio" => db_quote($_POST["prefVIO"]),
		"kitchen" => db_quote($_POST["prefKitchen"]),
		"warehouse" => db_quote($_POST["prefWarehouse"])
	];

	return $preferredDepartments;
}

function emergencyContactExists() {
	$connection = db_connect();

	$firstName = regexForNames($_POST['emergencyFirstName']);
	$firstName = db_quote($firstName);

	$lastName = regexForNames($_POST['emergencyLastName']);
	$lastName = db_quote($lastName);

	$rows = db_select("SELECT emergency_contact_id FROM emergency_contact WHERE emergency_contact_fname={$firstName} AND emergency_contact_lname={$lastName}");

	return ($rows) ? $rows[0]['emergency_contact_id'] : false;
}

function newRowId($connection) {
	if($connection->error) {
		return false;
	} else {
		return $connection->insert_id;
	}	
}

function makeEmergencyContactRow() {
	$connection = db_connect();

	$firstName = regexForNames($_POST['emergencyFirstName']);
	$firstName = db_quote($firstName);

	$lastName = regexForNames($_POST['emergencyLastName']);
	$lastName = db_quote($lastName);

	db_query("INSERT INTO emergency_contact (emergency_contact_fname, emergency_contact_lname) VALUES ({$firstName}, {$lastName})");

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

	db_query("INSERT INTO jnct_volunteer_emergency_contact (volunteer_fk, emergency_contact_fk, relationship, phone) VALUES ({$volunteerId}, {$emergencyContactId}, {$relationship}, {$phone})");

	return newRowId($connection);
}

?>