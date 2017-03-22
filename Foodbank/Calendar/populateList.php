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
$sql = "SELECT volunteer_id, volunteer_fname, volunteer_lname, volunteer_status FROM volunteer";
$result = $conn->query($sql);


if($_GET['q'] == 'false')
{
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			if($row['volunteer_status'] == 1)
			{
				echo "<option value='" . $row['volunteer_id']. "'>" . $row['volunteer_id'] . ":" . $row['volunteer_fname']. " " . $row['volunteer_lname']. "</option>";
			}
		}
	}
}
else
{
	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			echo "<option value='" . $row['volunteer_id']. "'>" . $row['volunteer_id'] . ":" . $row['volunteer_fname']. " " . $row['volunteer_lname']. "</option>";
		}
	}
}


$conn->close();



?>