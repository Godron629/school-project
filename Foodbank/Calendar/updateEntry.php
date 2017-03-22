<!-- Jeff Emshey 3/14/2017 -->
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">


<script>
function populateList(str, who) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("List").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "populateListSelected.php?q=" + str + "&who=" + who, true);
        xmlhttp.send();
}
</script>
<script>
function changeMonth(month, buttonName, id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				location.href = '/Foodbank/Calendar/updateEntry.php?id=' + id;
                
            }
        };

			xmlhttp.open("GET", "changeMonth.php?q=" + month + "&btn=" + buttonName, true);
			xmlhttp.send();
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script>
		$(document).ready(function() {
			$('table select').change(function() {
				$('table select').not(this).val(0);
			});
		});
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
		
	
	</head>
<h1>
		<a href="/Foodbank/Admin/home.php">
			<img id="logo" src="/Foodbank/images/logo.gif">
		</a>
		<a href="/Foodbank/Calendar/">Calendar
	</a> > Update Entry</h1>
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
<body class="wrapper">
<?php
//give proper formatting

session_start();
date_default_timezone_set('America/Edmonton');
$errmac = false;
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

$sql = "SELECT * FROM calendar_entry where calendar_entry_id={$_GET['id']}";
$result = $conn->query($sql);

// output data of each row
$row = $result->fetch_assoc();
	
$sqlOtherTable = "SELECT volunteer_status FROM volunteer where volunteer_id={$row['volunteer_id']}";	
$resultTwo = $conn->query($sqlOtherTable);
$getStatus = $resultTwo->fetch_assoc();	
//echo "calendar ID: " . $row['calendar_entry_id']. ", volunteer ID: " . $row['volunteer_id'] . ", date: " . $row['calendar_date'] . ", calendar dept: " . $row['calendar_dept']. ", calendar shift:  " . $row['calendar_shift']. ", Volunteer Status: ". $getStatus['volunteer_status']. "<br>";
		 	 
//Inactive field & volunteer list 
echo "Include Inactive: <input type='checkbox' name='searchInactive' value='test' onchange='populateList(this.checked, {$row['volunteer_id']})'"; if($getStatus['volunteer_status'] == 0){echo"checked";} echo"></input><br>";	
print ("<form method='post' action=''>
		<div>
		<select class='test' name='people[]' id='List'>
		</select>
		</div><br>
		");
echo "<select name='shift'>";
if($row['calendar_shift'] == 'Morning')
	{
		echo "<option selected value='Morning'>Morning</option>";
	}
	else
	{
		echo "<option value='Morning'>Morning</option>";
	}
	if($row['calendar_shift'] == 'Afternoon')
	{
		echo "<option selected value='Afternoon'>Afternoon</option>";
	}
	else
	{
		echo "<option value='Afternoon'>Afternoon</option>";
	}
	echo "</select>";
	echo "<select name='department'>";
	if($row['calendar_dept'] == 'Front')
	{
		echo "<option selected value='Front'>Front</option>";
	}
	else
	{
		echo "<option value='Front'>Front</option>";
	}
	if($row['calendar_dept'] == 'Volunteer Intake Coordinator')
	{
		echo "<option selected value='Volunteer Intake Coordinator'>Volunteer Intake Coordinator</option>";
	}
	else
	{
		echo "<option value='Volunteer Intake Coordinator'>Volunteer Intake Coordinator</option>";
	}
	if($row['calendar_dept'] == 'Warehouse')
	{
		echo "<option selected value='Warehouse'>Warehouse</option>";
	}
	else
	{
		echo "<option value='Warehouse'>Warehouse</option>";
	}
	if($row['calendar_dept'] == 'Kitchen')
	{
		echo "<option selected value='Kitchen'>Kitchen</option>";
	}
	else
	{
		echo "<option value='Kitchen'>Kitchen</option>";
	}
	echo "</select>";
		
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
echo "<caption style='border: solid 1px; background: white; margin-bottom: 10px; font-size: 30px;'>"; ?> <button style='margin: 10px 0px 10px 10px; float: left;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "back", <?php echo $_GET['id']; ?>)' <?php if($_SESSION['currMonth'] == 1) echo "disabled"; ?><?php echo "><</button>{$temp2} {$year}"; ?> <button style='margin: 10px 10px 10px 0px; float: right;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "forward", <?php echo $_GET['id']; ?>)' <?php if($_SESSION['currMonth'] == 12) echo "disabled"; ?>>></button> <?php echo "</caption>";

for($i = 0; $i < 7; $i++)
	{
		echo "<td>{$daysOfTheWeekRev[$i]}</td>";
	}
	echo "</tr>";

for($j = 0; $j < 6; $j++)
{
	echo "<tr>";
	for($i = 0; $i < 7; $i++)
	{
		if($j == 0 && $i < $daysOfTheWeek[$test['dayname']])
		{	
			echo "<td>{$dayOne}</td>";
		}
			else
			{
				if($days <= $daysInMonth)
				{
					echo "<td>";
					echo		"<select multiple='multiple' name='days[]'style='overflow: hidden; height: 90%; width: 100%; text-align: center;'>";
					echo		"<option value='{$dateArray[$days]}'"; if($dateArray[$days] == $row['calendar_date']){echo "disabled style='color: #CCCCCC;'";}  echo ">{$days}</option>";
					echo		"</select>";
					echo	"</td>";
					$days++;
				}
				else
					echo "<td>{$dayOne}</td>";
			}
	}
	echo "</tr>";
}
echo "</table><br>";
	echo	"<input class='bbw' type='submit' value='Back' name = 'Back'/>";
	echo	"<input class='bbw' type='submit' value='Accept' name='Accept'/>";
	echo "</form>";	 

//check to see if we're posted from the index
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//check if the post was the back button
	if(isset($_POST['Back']))
	{
		echo "<script>location.href = 'http://localhost:8080/Foodbank/Calendar/';</script>"; //send back to calendar without updating
	}
	else
	{
		//handle default & selected values for the volunteer change list
		if(!isset($_POST['people']))
		{
			$person = $row['volunteer_id'];
		}
		else
		{
			$person = $_POST['people'];
		}
		
		//handle default and selected values for day change from calendar
		if(!isset($_POST['days']))
		{
			$newDay = $row['calendar_date'];
		}
		if(isset($_POST['days']) && sizeOf($_POST['days']) > 1)
		{
			echo "Error! Attempted to reschedule a single shift to multiple days. Please ensure that you have selected only ONE day from the calendar."; 
			$errmac = true;
		}
		if(isset($_POST['days']))
		{
			$newDayTemp = $_POST['days'];
			$newDay = $newDayTemp[0];
		}

		//handle default and selected values for shift change
		if(!isset($_POST['shift']))
		{
			$newShift = $row['calendar_shift'];
		}
		else
		{
			$newShift = $_POST['shift'];
		}
		
		//handle default and selected values for department change
		if(!isset($_POST['department']))
		{
			$newDept = $row['calendar_dept'];
		}
		else
		{
			$newDept = $_POST['department'];
		}

		//check the database to ensure that the user is not trying to change this shift to a new person who is already working for that specified day & shift
		$selectSQL = "SELECT volunteer_id, calendar_date, calendar_shift FROM calendar_entry where volunteer_id='". $person[0] ."' AND calendar_date='" . $newDay . "' AND calendar_shift='" . $newShift . "'";
		$selectResult = $conn->query($selectSQL);
		$rowCount = $selectResult->num_rows;	
		
		if($rowCount > 0) //if no entries are returned, schedule the volunteer
		{
			$errmac = true;
		}
		
		if($errmac == false) //if the data is clean update it
		{
			$sql = "UPDATE calendar_entry SET volunteer_id=".$person[0].", calendar_date='".$newDay."', calendar_dept='".$newDept."', calendar_shift='".$newShift."' WHERE calendar_entry_id=".$row['calendar_entry_id'];
			$conn->query($sql);
			echo "<script>location.href = 'http://localhost:8080/Foodbank/Calendar/';</script>"; //send back to calendar after update
		}
	} 
}
$conn->close();
?>
</center>
</body>
<body onload="populateList(document.getElementsByName('searchInactive').checked = <?php if($getStatus['volunteer_status'] == 0){echo"true";}else{echo"false";}?>, <?php echo $row['volunteer_id']; ?>)"></body>
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