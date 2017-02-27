<?php include 'myPHPFiles/databasePHPFunctions.php';
	$connection = db_connect();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
</head>
<body>

<form>
	<input id="check1" type="checkbox" name="mondayAM">
	<input id="check2" type="checkbox" name="mondayPM">
	<input id="check3" type="checkbox" name="tuesdayAM">
	<input id="check4" type="checkbox" name="tuesdayPM">
	<input type="submit">
</form>

</body>
</html>