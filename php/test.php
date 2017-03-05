<?php 
include 'databasePHPFunctions.php';

$result = db_select('SELECT * FROM volunteer');

	$json = json_encode($result[1]);

?>

<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	#textbox, #textbox2 {
		display: block;
		margin-bottom: 10px;
	}	

	select {
		width: 300px;
	}
</style>

<title>Test</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $("#testSelect").select2();
});

</script>

<script src="testjs.js"></script>

</head>
<body>


<table>
	<select class="things" id="testSelect" multiple>
		<?php 
			$result = db_query("SELECT * FROM volunteer");

			foreach ($result as $key => $value) {
				if($value['volunteer_status'] == 1) {
					echo "<option>{$value['volunteer_fname']}</option>";
				} else {
					/*echo "<option>{$value['volunteer_fname']}</option>";*/
					echo "<option class='inactive'>Butt</option>";
				}
			}
		?>
	</select>
</table>

<input class="checkTest" type="checkbox" name="checkthings">
<input class="checkTest" type="checkbox" name="checkthings">
<input class="checkTest" type="checkbox" name="checkthings">
<input class="checkTest" type="checkbox" name="checkthings">
<input class="checkTest" type="checkbox" name="checkthings">

<button id="testButton" type="button">Load Volunteer</button>

</body>
</html>