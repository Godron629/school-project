<?php
	var_dump($_GET);
?>

<!DOCTYPE html>
<html>
<head>
<title>Test</title>

</head>

<body>

	<form method="GET" action="" id="testForm">
		<select name="select1[]" multiple id="select1">
			<option value="Car">Car</option>
			<option value="Truck">Truck</option>
			<option value="Jeep">Jeep</option>
		</select>

		<select name="select2[]" multiple id="select2">
			<option value="Cat">Cat</option>
			<option value="Dog">Dog</option>
			<option value="Mouse">Mouse</option>
		</select>

		<input type="submit" name="submitButton">
		<a href="?"><button type="button">Clear $_GET</button></a>
	</form>

</body>
</html>