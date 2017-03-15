<?php include $_SERVER['DOCUMENT_ROOT'] . "/php/databasePHPFunctions.php";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$volunteerId = db_quote($_POST["id"]);
		deleteVolunteer($volunteerId);
	}

	function deleteVolunteer($volunteerId) {
		db_query("DELETE FROM volunteer WHERE volunteer_id={$volunteerId}");
		db_query("DELETE FROM jnct_volunteer_emergency_contact WHERE volunteer_fk={$volunteerId}");
		return;
	}

?>