<?php include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		changedFields();
	}

function changedFields() {
	//Entire form was serialized with jQuery before Ajax call
	$origForm = undoSerializeForm($_POST["form1"]);
	$changeForm = undoSerializeForm($_POST["form2"]);

	$changedFields = valueOfChangedFields($origForm, $changeForm);

	$changedColumns = fieldNameToDatabaseColumn($changedFields, $changeForm);

	return $changedFields;
}

function undoSerializeForm($form) {
	$newForm = array();
	parse_str($form, $newForm);
	return $newForm;
}

function valueOfChangedFields($origForm, $changeForm) {
	//Makes a boolean array of all the form fields. True value if field changed.
	$didFieldChange = compareForms($origForm, $changeForm);

	//Get the form input name attributes
	$keysOfForm = array_keys($changeForm);

	$changedFields = array();

	//If the field changed, add the form input name attribute and the new value to the changedFields array
	$i = 0;
	foreach ($changeForm as $key => $value) {
		if($didFieldChange[$i]) {
			$changedFields[$key] = $value;
		}
		$i++;
	}

	changeAvailiabilityRows($changedFields, $changeForm);
	changeDepartmentRows($changedFields, $changeForm);

	return $changedFields;
}

function compareForms($origForm, $changeForm) {
	//Compares two forms, returns boolean array. True is field value is different across the forms.
	$didFieldChange = array_map(function($origForm, $changeForm) {
			return $origForm != $changeForm;
		}, $origForm, $changeForm);

	return $didFieldChange;
}

function changeAvailiabilityRows($changedFields, $changeForm) {
	//Check if the changes include any of the preferred availiability checkboxes
	$keysOfChangedFields = array_keys($changedFields);
	$changedAvailFields = preg_grep("/\w*(AM|PM)\b/", $keysOfChangedFields); 	
	$volunteerId = $changeForm["volunteerId"];

	if($changedAvailFields) {
		foreach ($changedAvailFields as $key => $value) {
			//Split up ex.mondayAM into 'monday' and 'am'
			$day = preg_replace("/[^a-z]/", "", $value);
			$time = preg_replace("/[^A-Z]/", "", $value);
			$time = strtolower($time);

			$sql = "SELECT {$time} FROM pref_avail WHERE volunteer_fk={$volunteerId} AND weekday='{$day}'";
			$row = db_select($sql);
			$oldCheckboxValue = $row[0][$time];

			//Change the value to the opposite 
			if($oldCheckboxValue === "no") {
				db_query("UPDATE pref_avail SET {$time}='yes' WHERE weekday='{$day}' AND volunteer_fk={$volunteerId}");
			} else {
				db_query("UPDATE pref_avail SET {$time}='no' WHERE weekday='{$day}' AND volunteer_fk={$volunteerId}");
			}
		}
		return true;
	}
	//No checkboxes changed
	return false;
}

function changeDepartmentRows($changedFields, $changeForm) {
	$keysOfChangedFields = array_keys($changedFields);
	$changedDeptFields = preg_grep("/\b(pref)/", $keysOfChangedFields);

	$volunteerId = $changeForm["volunteerId"];

	if($changedDeptFields) {
		foreach ($changedDeptFields as $key => $value) {
			switch ($value) {
				case 'prefFront':
					$department = 'front';
					break;
				case 'prefVIO':
					$department = 'vio';
					break;
				case 'prefKitchen':
					$department = 'kitchen';
					break;
				case 'prefWarehouse':
					$department = 'warehouse';
					break;
				default:
					break;
			}
			$sql = "SELECT allow FROM pref_dept WHERE volunteer_fk={$volunteerId} AND department='{$department}'";
			$row = db_select($sql);
			$oldCheckboxValue = $row[0]["allow"];

			$allowed = $oldCheckboxValue === "no" ? 'yes' : 'no';

			$test = db_query("UPDATE pref_dept SET allow='{$allowed}' WHERE volunteer_fk={$volunteerId} AND department='{$department}'");
		}
	}
}

function fieldNameToDatabaseColumn ($changedFields, $changeForm) {
	//Json file maps form input names to database columns. 
	$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/javascript/databaseColumnNames.json');

	/* Json file format
	* {
	*	"Volunteer" : {
	*		"volunteerFirstName" : "volunteer_fname",
	* 		...	
	* 	}, 
	* 	"EmergencyContact" : {...}
	* }
	*/

	//Decoded json into associative array
	$fieldToColumnMap = json_decode($jsonFile, true);

	$changedColumns = array();

	foreach ($fieldToColumnMap as $table => $value) {
		if(is_array($value)) {
			foreach ($value as $fieldName => $columnName) {
				if(array_key_exists($fieldName, $changedFields)) {
					/*$changedColumns[] = $columnName;*/
					$fieldValue = $changeForm[$fieldName];
					$volunteerId = $changeForm["volunteerId"];
					$sql = "UPDATE volunteer SET {$columnName}='{$fieldValue}' WHERE volunteer_id={$volunteerId} ";
					$test = db_query($sql);
				}	
			}
		}
	}



	return $changedColumns;
}
	
?>
