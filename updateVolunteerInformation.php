<?php include "newVolunteerFunctions.php";
echo "<select name='people'>";

$conn = connectDB();

//populate multi-select list
$sql = "SELECT volunteer_id, volunteer_fname, volunteer_lname, volunteer_status FROM volunteer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
		if($row['volunteer_status'] == 1)
		{
			echo "<option value='" . $row['volunteer_id']. "'>" . $row['volunteer_id'] . ":" . $row['volunteer_fname']. " " . $row['volunteer_lname']. "<br>";
		}
    }
} else {
    echo "0 results";
}
$conn->close();

echo "</select>";

?>