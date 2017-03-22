<!-- Jeff Emshey 3/14/2017 -->
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script>
function populateList(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("List").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "populateList.php?q=" + str, true);
        xmlhttp.send();
}
</script>
<script>
function changeMonth(month, buttonName) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				location.href = 'http://localhost:8080/Foodbank/Calendar/newEntry.php';
                
            }
        };

			xmlhttp.open("GET", "changeMonth.php?q=" + month + "&btn=" + buttonName, true);
			xmlhttp.send();
}
</script>
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
<h1>
		<a href="/Foodbank/Admin/home.php">
			<img id="logo" src="/Foodbank/images/logo.gif">
		</a>
		<a href="/Foodbank/Calendar/">Calendar
	</a> > New Entry</h1>
	<div id="topRightNav">
	<a href="/Foodbank/TimeClock/index.php">Time Clock</a>
		<a href="/Foodbank/Admin/logout.php" class="loginButton">Logout</a>
	</div>

	<div id="mainNav">
		<ul>
			<li><a href="/Foodbank/Admin/home.php">Home</a></li>
			<li  class="active"><a href="/Foodbank/Calendar/">Calendar</a></li>
			<li>
				<a>Manage Volunteers</a>
				<ul class="dropdown">
					<li><a href="/Foodbank/Volunteer/newVolunteer.php">New Volunteer</a></li>
					<li><a href="/Foodbank/Volunteer/updateVolunteer.php">Update Volunteer</a></li>
					<li><a href="#">Update Time Entries</a></li>
				</ul>
			</li>
			<li><a href="/Foodbank/Reports/reports.php">Reports</a></li>
		</ul>
	</div>
	<br>

<form method='post' action=''>
<body class="wrapper" onload="populateList(document.getElementsByName('searchInactive').checked = false)"></body>

<?php
session_start();
date_default_timezone_set('America/Edmonton');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodbank";
$default = 0;


echo "<form method='post' action=''>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


//check to see if we're posted from the index
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//check if the post was the back button
	if(isset($_POST['Back']))
	{
		$_SESSION['calDept'] = null;
		$_SESSION['currMonth'] = null;
		header('Location: http://localhost:8080/Foodbank/Calendar/'); //send back to calendar without updating
	}
	else
	{
		if(isset($_POST['people']) && isset($_POST['days'])) //check to make sure the user didn't leave any selection fields blank
		{
			//do database stuff
			$shift = $_POST['shift'];
			$department = $_POST['department'];
			foreach ($_POST['days'] as $selectedOptionDate)
			{
				foreach ($_POST['people'] as $selectedOption)
				{
					//for each volunteer selected check to see if they have an entry already in the database for each day selected AND the same shift. Volunteers cannot have multiple entries per day that have the same shift.
					$selectSQL = "SELECT volunteer_id, calendar_date, calendar_shift FROM calendar_entry where volunteer_id='". $selectedOption ."' AND calendar_date='" . $selectedOptionDate . "' AND calendar_shift='" . $shift . "'";
					$selectResult = $conn->query($selectSQL);
					$rowCount = $selectResult->num_rows;
					
					
					if($rowCount == 0) //if no entries are returned, schedule the volunteer
					{
						$sql = "insert into calendar_entry (calendar_entry_id, volunteer_id, calendar_date, calendar_dept, calendar_shift, crossed_out) values (NULL," . $selectedOption . ",'" . $selectedOptionDate . "', '" . $department . "', '" . $shift . "', {$default})";
						$conn->query($sql);
					}
				}
			}
			
		
			$conn->close();
			$_SESSION['calDept'] = null;
			$_SESSION['currMonth'] = null;
			header('Location: http://localhost:8080/Foodbank/Calendar/');
		}
		else
		{
			echo "<script>alert('Nothing Updated! Please ensure all fields are filled out.')</script>";
		}
	}
}

//Inactive and volunteer list
echo "Include Inactive: <input type='checkbox' name='searchInactive' value='test' onchange='populateList(this.checked)'></input><br>";
print	("<div>	
		<select class='test' multiple='multiple' name='people[]' id='List'>
		</select>
		</div><br>
	
	<select name='shift'>
	<option value='Morning'>Morning</option>
	<option value='Afternoon'>Afternoon</option>
</select>

<select name='department'>
	<option value='Front'>Front</option>
	<option value='Volunteer Intake Coordinator'>Volunteer Intake Coordinator</option>
	<option value='Warehouse'>Warehouse</option>
	<option value='Kitchen'>Kitchen</option>
</select>
	");

//multi day scheduler

//get current month/year data
$currDate = getdate();
if(!isset($_SESSION['currMonth']))
{
	$_SESSION['currMonth'] = $month = $currDate['mon'];
}
$month = $_SESSION['currMonth'];
$year = $currDate['year'];

//set up arrays for a bunch of awkward conversions, since some of these date functions return numeric values to represent days and some return name of days and we need to display the numeric values
$daysOfTheWeek = array("Sunday" => "0", "Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6");
$daysOfTheWeekRev = array("0" => "Sunday", "1" => "Monday", "2" => "Tuesday", "3" => "Wednesday", "4" => "Thursday", "5" => "Friday", "6" => "Saturday");

//get the start of the month values
$startOfMonth = unixtojd(mktime(0, 0, 0, $month, 2, $year));
$test = (cal_from_jd($startOfMonth, CAL_GREGORIAN));

//calendar formatting variables
$dayOne = "";
$days = 1;

//get how many days are in the current month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 

//create an array to hold all the properly formmated days of the current month. Because the database requires a specific format, this array ensures each selected date in the calendar will have the propery format
$dateArray = array();
for($i = 0; $i <= $daysInMonth; $i++)
{
$tempString = "{$year}";
	
	if($month < 10)
	{
		$tempString .= "-0{$month}";
	}
	else
	{
		$tempString .= "-{$month}";
	}
	if($i < 10)
	{
		$tempString .= "-0{$i}";
	}
	else
	{
		$tempString .= "-{$i}";
	}
	array_push($dateArray, $tempString);
}
?>

<center>
<?php
$monthNum  = $_SESSION['currMonth'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
$temp2 = $monthName;

//Create the table/calendar

echo "<table width='100%' height='550px' style='font-size: 14px;'>";
echo "<caption style='border: solid 1px; background: white; margin-bottom: 10px; font-size: 30px;'>"; ?> <button style='margin: 10px 0px 10px 10px; float: left;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "back")' <?php if($_SESSION['currMonth'] == 1) echo "disabled"; ?><?php echo "><</button>"; ?> <button style='margin: 10px 10px 10px 0px; float: right;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "forward")' <?php if($_SESSION['currMonth'] == 12) echo "disabled"; ?>>></button><?php echo "{$temp2} {$year}"; ?>  <?php echo "</caption>";

for($i = 0; $i < 7; $i++)
	{
		echo "<td style='text-align: center;'>{$daysOfTheWeekRev[$i]}</td>";
	}
	echo "</tr>";

for($j = 0; $j < 6; $j++)
{
	echo "<tr>";
	for($i = 0; $i < 7; $i++)
	{
		if($j == 0 && $i < $daysOfTheWeek[$test['dayname']])
		{	
			echo "<td>&nbsp;</td>";
		}
			else
			{
				if($days <= $daysInMonth)
				{
					echo "<td>
							<select multiple='multiple' name='days[]' style='overflow: hidden; height: 90%; width: 100%; text-align: center;'>
							<option  value='{$dateArray[$days]}'>{$days}</option> 
							</select>
						</td>";
					$days++;
				}
				else
					echo "<td>&nbsp;</td>";
			}
	}
	echo "</tr>";
}
echo "</table><br>";



print ("

	<input class='bbw' type='submit' value='Back' name = 'Back'/>
	<input class='bbw' type='submit' value='Accept' name='Accept'/>
	
	
	
</form>


");

?>
</center>
<style>
table
{
	border-collapse:collapse;
	overflow: auto;
}
td
{
	background:white;
	border:1px solid #000; 
	width: 10%;
	height: 10%;
	overflow: auto;
}
option,
option:hover,
option:checked
{
	height: 100%;
}
</style>