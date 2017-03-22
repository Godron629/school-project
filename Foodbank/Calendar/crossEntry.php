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
$sql = "select crossed_out from calendar_entry WHERE calendar_entry_id=".$_GET['q'];
$result = $conn->query($sql);
$entry = $result->fetch_assoc();

if($entry['crossed_out'] == 0)
{
	//update the crossed out field
	$sql = "UPDATE calendar_entry SET crossed_out='1' WHERE calendar_entry_id=".$_GET['q'];
}
else
{
	//update the crossed out field
	$sql = "UPDATE calendar_entry SET crossed_out='0' WHERE calendar_entry_id=".$_GET['q'];
}
$conn->query($sql);
$conn->close();



?>