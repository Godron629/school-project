<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		createVolunteer();
	}

	function createVolunteer() {
		if(volunteerExists()) {
			return db_error();
		} 

		if ($volunteerId = makeVolunteerRecord()) {
			makePreferredAvailabilityRecord($volunteerId);
			makePreferredDepartmentRecord($volunteerId);

			if($emergencyContactId = emergencyContactExists()) {
				joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
			} else {
				$emergencyContactId = makeEmergencyContactRecord();
				joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId);
			}
		} else {
			echo "Error: Volunteer record creation unsuccessful:" . db_error();
		}
	}

	function volunteerExists() {
		$firstName = db_quote($_POST['volunteerFirstName']);
		$lastName = db_quote($_POST['volunteerLastName']);
		$birthdate = db_quote($_POST['volunteerDOB']);

		$rows = db_select("SELECT volunteer_id FROM volunteer WHERE volunteer_fname=$firstName AND volunteer_lname=$lastName AND volunteer_birthdate=$birthdate");

		return ($rows) ? true : false; 
	}

	function makeVolunteerRecord() {
		$connection = db_connect();

		//real_escape_string form inputs and remove symbols from apropriate fields
		$firstName = db_quote($_POST['volunteerFirstName']);

		$lastName = db_quote($_POST['volunteerLastName']);

		$email = db_quote($_POST['volunteerEmail']);
		$birthdate = db_quote($_POST['volunteerDOB']);
		$gender = db_quote($_POST['volunteerGender']);

		$address = db_quote($_POST['volunteerAddress']);

		$city = db_quote($_POST['volunteerCity']);

		$province = db_quote($_POST['province']);
		$postalCode = db_quote($_POST['postalCode']);

		$primaryPhone = removeSymbolsFromPhone($_POST['volunteerPrimaryPhone']);
		$primaryPhone = db_quote($primaryPhone);

		//Secondary phone is not requred
		$secondaryPhone = getSecondaryPhoneFromForm();

		//Volunteers are active by default
		$volunteerStatus = true;

		db_query("INSERT INTO volunteer (volunteer_fname, volunteer_lname, volunteer_email, volunteer_birthdate, volunteer_gender, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone, volunteer_secondaryphone, volunteer_status) VALUES ($firstName, $lastName, $email, $birthdate, $gender, $address, $city, $province, $postalCode, $primaryPhone, $secondaryPhone, $volunteerStatus)");

		return wasAutoIncrementQuerySuccesful($connection);
	}

	function removeSymbolsFromPhone($phone) {
       $phone = preg_replace("([^0-s]+)", "", $phone);
       return $phone;
    }

   	function getSecondaryPhoneFromForm() {
		if(empty($_POST['volunteerSecondaryPhone'])) {
			return db_quote("None");
		} else {
			$phone = removeSymbolsFromPhone($_POST['volunteerSecondaryPhone']);
			return db_quote($phone);
		}
	}

	function makePreferredAvailabilityRecord($volunteerId) {
		$connection = db_connect();
		$daysAndShifts = getDaysAndShiftsFromForm();
		
		foreach($daysAndShifts as $key => $value) {
			db_query("INSERT INTO pref_avail (volunteer_fk, weekday, am, pm) VALUES ($volunteerId, {$key}, {$value['AM']}, {$value['PM']})");
		}
		return wasAutoIncrementQuerySuccesful($connection);
	}

	function getDaysAndShiftsFromForm() {
		$weekdays = ["monday", "tuesday", "wednesday", "thursday", "friday"];
		$daysAndShifts = array();
		
		foreach ($weekdays as $value) {
			$daysAndShifts[db_quote($value)] = ["AM" => db_quote($_POST[$value . 'AM']), "PM" => db_quote($_POST[$value . 'PM'])];
		}
		return $daysAndShifts;
	}

	function makePreferredDepartmentRecord($volunteerId) {
		$connection = db_connect();
		$selectedDepartments = getDepartmentsFromForm();

		foreach($selectedDepartments as $key => $value) {
			db_query("INSERT INTO pref_dept (volunteer_fk, department, allow) VALUES ($volunteerId, '{$key}', {$value})");
		}
		return wasAutoIncrementQuerySuccesful($connection);
	}

	function getDepartmentsFromForm() {
		$connection = db_connect();

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

		$rows = db_select("SELECT emergency_contact_id FROM emergency_contact WHERE emergency_contact_fname={$firstName} AND emergency_contact_lname={$lastName}");

		return ($rows) ? $rows[0]['emergency_contact_id'] : false;
	}

	function wasAutoIncrementQuerySuccesful($connection) {
		if($connection->error) {
			return false;
		} else {
			//Success: Return the autoincrement Id
			return $connection->insert_id;
		}	
	}

	function makeEmergencyContactRecord() {
		$connection = db_connect();

		$firstName = removeSymbolsFromText($_POST['emergencyFirstName']);
		$firstName = db_quote($_POST['emergencyFirstName']);

		$lastName = removeSymbolsFromText($_POST['emergencyLastName']);
		$lastName = db_quote($_POST['emergencyLastName']);

		db_query("INSERT INTO emergency_contact (emergency_contact_fname, emergency_contact_lname) VALUES ($firstName, $lastName)");

		return wasAutoIncrementQuerySuccesful($connection);
	}

	function joinVolunteerAndEmergencyContact($volunteerId, $emergencyContactId) {
		$connection = db_connect();

		$volunteerId = db_quote($volunteerId);
		$emergencyContactId = db_quote($emergencyContactId);
		$relationship = db_quote($_POST['emergencyRelationship']);

		$phone = removeSymbolsFromPhone($_POST['emergencyPhone']);
		$phone = db_quote($phone);

		db_query("INSERT INTO jnct_volunteer_emergency_contact (volunteer_fk, emergency_contact_fk, relationship, phone) VALUES ($volunteerId, $emergencyContactId, $relationship, $phone)");

		return wasAutoIncrementQuerySuccesful($connection);
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