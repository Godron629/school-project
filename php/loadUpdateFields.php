<?php include 'databaseFunctions.php';

$volunteerId = $_POST['id']; 

$volunteer = db_select("SELECT * FROM jnct_volunteer_emergency_contact JOIN volunteer ON jnct_volunteer_emergency_contact.volunteer_fk = volunteer.volunteer_id JOIN emergency_contact ON jnct_volunteer_emergency_contact.emergency_contact_fk = emergency_contact.emergency_contact_id WHERE volunteer_id = $volunteerId");

$avail = db_select("SELECT weekday, am, pm FROM pref_avail
WHERE volunteer_fk = $volunteerId");

$departments = db_select("SELECT department, allow FROM pref_dept WHERE volunteer_fk = $volunteerId");

echo json_encode(array("Volunteer" => $volunteer[0], "Dep" => $departments ,"Avail" => $avail));
?>