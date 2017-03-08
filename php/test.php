<?php
	var_dump($_GET);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Deselect on Select</title>

	<style type="text/css"> 
		input[type="submit"] {display: block; margin: 6px 0;}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script>
		$(document).ready(function() {
			$('select option').on('mousedown', function(event) {

				//Don't automatically just select it on click	
				event.preventDefault();

				//ctrlKey is a boolean, whether or not the ctrl key has been pressed. So, make it always true.
				event.ctrlKey = true;

				var $option = $(this);

				//Bring focus to the parent(select), manually done because preventDefault() prevents this
				$option.parent().focus();

				if($option.prop('selected')) {
					$option.prop('selected', false);
				} else {
					$option.prop('selected', true);
				}
			});
		});
	</script>

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