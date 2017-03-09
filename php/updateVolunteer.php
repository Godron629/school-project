<?php include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		updateVolunteer();
	}

function updateVolunteer() {
	$changedFields = changedFields();
	echo json_encode($changedFields);
}

function changedFields() {
	$origForm = array();
	$changeForm = array();

	//Undo serialize done in jQuery before Ajax call
	parse_str($_POST["form1"], $origForm);
	parse_str($_POST["form2"], $changeForm);

	$fieldsThatChanged = keysOfChangedFields($origForm, $changeForm);

	return $fieldsThatChanged;
}

function keysOfChangedFields($origForm, $changeForm) {
	$didFieldChange = compareForms($origForm, $changeForm);

	$keysOfForm = array_keys($changeForm);
	$keysOfChangedFields = array();

	$i = 0;
	foreach ($changeForm as $key => $value) {
		if($didFieldChange[$i]) {
			$keysOfChangedFields[] = $key;
		}
		$i++;
	}

	return $keysOfChangedFields;
}

function compareForms($origForm, $changeForm) {
	//Compares two forms, returns boolean array. True is field is different across the forms.
	$didFieldChange = array_map(function($origForm, $changeForm) {
			return $origForm != $changeForm;
		}, $origForm, $changeForm);

	return $didFieldChange;
}
		
?>
