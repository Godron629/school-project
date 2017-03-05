<?php include 'databasePHPFunctions.php';

$volunteerId = $_POST['id']; 

$result = db_select("SELECT * FROM volunteer WHERE volunteer_id='{$volunteerId}'");

echo json_encode($result[0]);
?>