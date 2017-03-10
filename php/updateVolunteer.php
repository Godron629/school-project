<?php include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		updateVolunteer();
	}

function updateVolunteer() {
	$changedFields = changedFields();
	$changedColumns = fieldNameToDatabaseColumn($changedFields);
}

function changedFields() {
	//Entire form was serialized with jQuery before Ajax call
	$origForm = undoSerializeForm($_POST["form1"]);
	$changeForm = undoSerializeForm($_POST["form2"]);

	$changedFields = valueOfChangedFields($origForm, $changeForm);

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

	return $changedFields;
}

function compareForms($origForm, $changeForm) {
	//Compares two forms, returns boolean array. True is field value is different across the forms.
	$didFieldChange = array_map(function($origForm, $changeForm) {
			return $origForm != $changeForm;
		}, $origForm, $changeForm);

	return $didFieldChange;
}

function fieldNameToDatabaseColumn ($changedFields) {
	//Json file maps form input names to database columns. 
	$jsonFile = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/javascript/databaseColumnNames.json');

	/* Json file format
	* {
	*	"Volunteer" : {
	*		"volunteerFirstName" : "volunteer_id",
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
				if(in_array($fieldName, $changedFields)) {
					$changedColumns[] = $columnName;
				}	
			}
		}
	}

	return $changedColumns;
}
		
?>
