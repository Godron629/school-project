<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script>
function delEntry(recordID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.href = 'http://localhost:8080/Calendar/';
            }
        };
			xmlhttp.open("GET", "delEntry.php?q=" + recordID, true);
			xmlhttp.send();
}
</script>
<script>
function crossEntry(recordID) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				location.href = 'http://localhost:8080/Calendar/';
                
            }
        };

			xmlhttp.open("GET", "crossEntry.php?q=" + recordID, true);
			xmlhttp.send();
}
</script>

<script>
function changeMonth(month, buttonName) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				location.href = 'http://localhost:8080/Calendar/';
                
            }
        };

			xmlhttp.open("GET", "changeMonth.php?q=" + month + "&btn=" + buttonName, true);
			xmlhttp.send();
}


</script>

<script>
function changeCal(buttonName) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				location.href = 'http://localhost:8080/Calendar/';
                
            }
        };

			xmlhttp.open("GET", "changeCal.php?q=" + buttonName, true);
			xmlhttp.send();
}


</script>
<body class="wrapper">
<?php
session_start();
//fix format
//give calendar a more calendar like look
//set up department calendars


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	session_destroy();
	header('Location: http://localhost:8080/Calendar/newEntry.php');
}

if(!isset($_SESSION['calDept']))
{
	$_SESSION['calDept'] = "Kitchen";
}

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
$daysOfTheWeek = array("Sunday" => "0", "Monday" => "1", "Tuesday" => "2", "Wednesday" => "3", "Thursday" => "4", "Friday" => "5", "Saturday" => "6");
$daysOfTheWeekRev = array("0" => "Sunday", "1" => "Monday", "2" => "Tuesday", "3" => "Wednesday", "4" => "Thursday", "5" => "Friday", "6" => "Saturday");


$currDate = getdate();
if(!isset($_SESSION['currMonth']))
{
	$_SESSION['currMonth'] = $month = $currDate['mon'];
}
$month = $_SESSION['currMonth'];
$year = $currDate['year'];
$currDay = $currDate['weekday'];

//get the number of days for the specified month defaults to current +- based on arrow button TBI
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 

$dateArray = array();

for($i = 1; $i <= $daysInMonth; $i++)
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


$startOfMonth = unixtojd(mktime(0, 0, 0, $month, 2, $year));
$test = (cal_from_jd($startOfMonth, CAL_GREGORIAN));
$temp = $daysOfTheWeek[$test['dayname']];
$dayOne = "";
$days = 1;
$entryID = 1;


$sql = "SELECT calendar_entry_id, volunteer_id, calendar_date, calendar_dept, calendar_shift, crossed_out FROM calendar_entry WHERE calendar_dept='".$_SESSION['calDept'] . "'"; //might add where statement to only look at entries for current month +, not behind
$result = $conn->query($sql);


$k = 0;
$scheduledDates= array();
$calendarEntryIDs = array();
$calendarFName = array();
$calendarLName = array();
$calendarVolIDs = array();
$cross_out = array();

while($row = $result->fetch_assoc())
{
	$tooLazytoJoin = "Select volunteer_fname, volunteer_lname FROM volunteer where volunteer_id='{$row['volunteer_id']}'";
	$toolazyResult = $conn->query($tooLazytoJoin);
	$tooLazyFetch = $toolazyResult->fetch_assoc();
	
	array_push($scheduledDates, $row['calendar_date']);
	array_push($calendarEntryIDs, $row['calendar_entry_id']);
	array_push($calendarVolIDs, $row['volunteer_id']);
	array_push($calendarFName, $tooLazyFetch['volunteer_fname']);
	array_push($calendarLName, $tooLazyFetch['volunteer_lname']);
	array_push($cross_out, $row['crossed_out']);
}
?>

<center>
<div style='width: 90%; height:35px; overflow: hidden;'>

<button style='float: right;' <?php if($_SESSION['calDept'] == "Kitchen"){echo "disabled";} ?> onclick='changeCal("Kitchen")'>Kitchen</button>
<button style='float: right;'<?php if($_SESSION['calDept'] == "Volunteer Intake Coordinator"){echo "disabled";} ?> onclick='changeCal("Volunteer Intake Coordinator")'>Volunteer Intake Coordinator</button>
<button style='float: right;'<?php if($_SESSION['calDept'] == "Front"){echo "disabled";} ?> onclick='changeCal("Front")'>Front</button>
<button style='float: right;'<?php if($_SESSION['calDept'] == "Warehouse"){echo "disabled";} ?> onclick='changeCal("Warehouse")'>Warehouse</button>

<br>
</div>
</center>
<?php
$monthNum  = $_SESSION['currMonth'];
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
$temp2 = $monthName;
echo "<center>";
echo "<table>";
echo "<caption style='border: solid 1px; background: white; margin-bottom: 10px; font-size: 40px; font-weight: bold;'>"; ?> <button style='margin: 10px 0px 10px 10px; float: left;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "back")' <?php if($_SESSION['currMonth'] == 1) echo "disabled"; ?><?php echo "><</button>";?> <button style='margin: 10px 10px 10px 0px; float: left;' onclick='changeMonth(<?php echo $_SESSION['currMonth']; ?>, "forward")' <?php if($_SESSION['currMonth'] == 12) echo "disabled"; ?>>></button><form method='post' action='' style=" margin: 10px 10px 0px 10px; float: right;">
	<button id='newEntry' name='newEntry'>New Entry</button>
</form><?php echo "{$temp2} {$year}"; ?>  <?php echo "</caption>";
for($i = 0; $i < 7; $i++)
	{
	echo "<td style='text-align: center; font-size: 20px;'><b>{$daysOfTheWeekRev[$i]}</b></td>";
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
					echo "<td>";
					
					if($days == date("j") && $_SESSION['currMonth'] == date("n"))
					{
						echo"<b>";
						echo "{$days}";
						echo"</b>";
					}
					else
					{
						echo "{$days}";
					}
					echo "<div>";
						foreach($scheduledDates as $index => $scheduledDay)
						{
							
							if($scheduledDay == $dateArray[$days -1])
							{
								echo "<div class='div2' id='{$calendarEntryIDs[$index]}'><a href='http://localhost:8080/Calendar/updateEntry.php?id={$calendarEntryIDs[$index]}'"; if($cross_out[$index] == 1){echo" style='text-decoration: line-through';";} echo"><span class='datText'>{$calendarVolIDs[$index]} : {$calendarFName[$index]} {$calendarLName[$index]}</span></a><button style='padding: 0px 0px 0px 0px; margin: 0px 5px 0px 5px; float: left;'onclick='delEntry({$calendarEntryIDs[$index]})'>X</button><button style='padding: 0px 0px 0px 0px; margin: 0px 5px 0px 5px; float: left;' onclick='crossEntry({$calendarEntryIDs[$index]})'><strike>abc</strike></button></div>";
								$k++;
							}
						}
					echo "</div>";
					echo "</td>";
					$days++;
				}
				else
					echo "<td>&nbsp;</td>";
			}
	}
	echo "</tr>";
}
echo "</table>";
echo "</center>";
$conn->close();
?>
</body>
<style type='text/css'>
table
{
	font-size: 14px;
	border-collapse:collapse;
	white-space: nowrap;
	overflow: hidden;
	width: 100%;
	table-layout:fixed;
}

tr
{
	width: 150px;
	height: 150px;
}

td
{
	display:table-cell;
	background: white;
	border:1px solid #000; 
	width: 150px;
	height: 150px;
    overflow: auto;
}
div
{
	width: 150px;
	height: 150px;
    margin: 0;
    padding: 0;
}
button
{
	margin: 0px 0px 0px 0px;
	font-size: 12px;
}
.div2
{
	width: 400%;
	height: 30px;
}
.datText
{
	
}
</style>
