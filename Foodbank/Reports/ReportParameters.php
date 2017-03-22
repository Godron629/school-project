	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<!--jQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<!--Select2 jQuery-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<!--Make elements of class 'test' into a jQuery object 
		and run the select2() function on it-->
	<script type="text/javascript">
		$(document).ready(function() {
			$('.test').select2({ width: '200px' });
		});	
	</script>

	
<?php
date_default_timezone_set('America/Edmonton');
	switch($_GET['q'])
	{
		case "report1":
		{
			echo "Volunteer Contact Information Report: <br><br>";
			echo "All Volunteers <input value='hide1' name='paramInclude' onChange='testFunc(this.checked, this.value)' type='radio'></input>";
			echo "| Active Volunteers <input name='paramInclude' value='hide2' onChange='testFunc(this.checked, this.value)' type='radio'></input>";
			echo "| Specific Volunteers <input name='paramInclude' value='show' onChange='testFunc(this.checked, this.value), populateList(this.checked)' type='radio'></input>";
			echo "<div id='ShowSpecificParams' hidden><br>";
			
			print("
					<div>	
						Select Volunteer(s) <select class='test' multiple='multiple' name='people[]' id='List'>
						</select>
					</div><br>");
			echo "</div>";
		} break;
		case "report2":
		{
			echo "Currently Clocked In: ";
		} break;
		case "report3":
		{
			$currDate = getdate();
			$sun_value= date('d', strtotime('Sunday this week'));
			$mon_value= date('d', strtotime('Monday this week'));
			
			echo "Weekly Schedule: " . $currDate['month'] . " " .$mon_value . " - " . $currDate['month'] . " " .$sun_value . ", " . " " . $currDate['year'];
	
			
		} break;
		case "report4":
		{
			echo "Total Hours Worked For The Specified Volunteer: <br><br>";
			
			print("
					<div  onSelectStart=(populateList(true))>	
						Select Volunteer <select class='test' name='people[]' id='List' >
						</select>
					</div><br>");
			
			
			
			
		} break;
		case "report5":
		{
			echo "Requires TimeClock Stuff - will do later";
		} break;
		case "report6":
		{
			echo "Volunteer Demographics in %: <br><br>";
			
			echo "Gender <input value='Gender' name='paramInclude' type='radio'></input>";
			echo "| Age <input name='paramInclude' value='Age' type='radio'></input>";
			echo "| Both <input name='paramInclude' value='Both' type='radio'></input>";
		} break;
		case "report7":
		{
			echo "Volunteer Availability: <br><br>";
			
			echo "Shift(s): <br>";
			echo "Morning <input name='am' type='checkbox'></input>";
			echo "| Afternoon <input name='pm' type='checkbox'></input><br><br>";
			
			echo "Day(s): <br>";
			echo "Monday <input name='monday' type='checkbox'></input>";
			echo "| Tuesday <input name='tuesday' type='checkbox'></input>";
			echo "| Wednesday <input name='wednesday' type='checkbox'></input>";
			echo "| Thursday <input name='thursday' type='checkbox'></input>";
			echo "| Friday <input name='friday' type='checkbox'></input><br><br>";
			
			echo "Department(s): <br>";
			echo "Front <input name='front' type='checkbox'></input>";
			echo "| Volunteer Intake Coordinator <input name='vio' type='checkbox'></input>";
			echo "| Kitchen <input name='kitchen' type='checkbox'></input>";
			echo "| Warehouse <input name='warehouse' type='checkbox'></input>";
			
		} break;
		default:
		{
			echo "you hit default.";
		} break;
		
		
	}

?>