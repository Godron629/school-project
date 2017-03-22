<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodbank";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//populate multi-select list
//$sql = "UPDATE calendar_entry SET volunteer_id=".$person[0].", calendar_date='".$newDay."', calendar_dept='".$newDept."', calendar_shift='".$newShift."' WHERE calendar_entry_id=".$row['calendar_entry_id'];
$sql = "delete from calendar_entry where calendar_entry_id='".$_GET['q']."'";

$conn->query($sql);
$conn->close();



?>