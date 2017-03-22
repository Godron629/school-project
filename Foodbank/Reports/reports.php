<style>
.calFormatVol
{
	border: solid;
	border-color: white;
	width: 13%;
	text-align: left;
	float: left;
	
}
</style>
<?php 
//echo $_GET['q'];
date_default_timezone_set('America/Edmonton');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodbank";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['reportType']))
	{
		switch($_POST['reportType'])
		{
			case "report1":
			{
				if(isset($_POST['paramInclude']) && $_POST['paramInclude'] == 'hide1')
				{
					$reportAppend = "";
					$sql = "select volunteer_fname, volunteer_lname, volunteer_email, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone from volunteer;";
					$result = $conn->query($sql);
				
					while($row = $result->fetch_assoc())
					{
						$report = "Name: " . $row['volunteer_fname'] . " " . $row['volunteer_lname'] . "<br> Email: " . $row['volunteer_email'] . "<br> Address: " . $row['volunteer_street'] . " <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $row['volunteer_city'] . ", " . $row['volunteer_province'] . ", " . $row['volunteer_postcode'] . "<br> Phone: " . $row['volunteer_primaryphone'] . "<br><br>";
						$reportAppend .= $report;
					}
				
					echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
				}
				else if(isset($_POST['paramInclude']) && $_POST['paramInclude'] == 'hide2')
				{
					$reportAppend = "";
					$sql = "select volunteer_fname, volunteer_lname, volunteer_email, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone from volunteer where volunteer_status = 1;";
					$result = $conn->query($sql);
				
					while($row = $result->fetch_assoc())
					{
						$report = "Name: " . $row['volunteer_fname'] . " " . $row['volunteer_lname'] . "<br> Email: " . $row['volunteer_email'] . "<br> Address: " . $row['volunteer_street'] . " <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $row['volunteer_city'] . ", " . $row['volunteer_province'] . ", " . $row['volunteer_postcode'] . "<br> Phone: " . $row['volunteer_primaryphone'] . "<br><br>";
						$reportAppend .= $report;
					}
				
					echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";					
				}
				else if(isset($_POST['paramInclude']) && $_POST['paramInclude'] == 'show' && isset($_POST['people']))
				{
					$reportAppend = "";
					foreach ($_POST['people'] as $selectedOption)
					{
						$sql = "select volunteer_fname, volunteer_lname, volunteer_email, volunteer_street, volunteer_city, volunteer_province, volunteer_postcode, volunteer_primaryphone from volunteer where volunteer_id ='" . $selectedOption . "';";
						$result = $conn->query($sql);
				
						while($row = $result->fetch_assoc())
						{
							$report = "Name: " . $row['volunteer_fname'] . " " . $row['volunteer_lname'] . "<br> Email: " . $row['volunteer_email'] . "<br> Address: " . $row['volunteer_street'] . " <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $row['volunteer_city'] . ", " . $row['volunteer_province'] . ", " . $row['volunteer_postcode'] . "<br> Phone: " . $row['volunteer_primaryphone'] . "<br><br>";
							$reportAppend .= $report;
						}
					}
					echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";					
				}			
			
			}break;
			case "report2":
			{
				
				$time = date("H:i:s");
				$date = date("Y-m-d");
				$path = "C:/wamp64/www/Foodbank/TimeClock/";
				$str = $path . $date . ".xml";
				echo $str;
				$myfile = fopen($str, "r") or die("Unable to open file!");
				
				$reportAppend = "";
				
				$xml= simplexml_load_file($str);
				$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));
				
				foreach($xml_array['entry'] as $test => $content)
				{
					if($content['clockOut'] == null)
					{
						$reading = fopen($str, 'r');
						while (!feof($reading))
						{
							$line = fgets($reading);
							if (stristr($line,'<id>'))
							{
								$newStr = "<id>". $content['id'] ."</id>";
								if(strcmp($line, $newStr) == 2)
								{
									$foundEntry = true;
								}
								else
								{
									$foundEntry = false;
								}
							}
							if(stristr($line,'<clockIn>') && $foundEntry == true)
							{
								$lineDB = substr($line, -20, 8);
							}		
						}
							$sql = "select volunteer_id, volunteer_fname, volunteer_lname from volunteer where volunteer_id='". $content['id'] . "'";
							$result = $conn->query($sql);
							$user = $result->fetch_assoc();
							
							$sql2 = "select calendar_dept, calendar_shift from calendar_entry where volunteer_id='". $content['id'] . "' AND calendar_date='{$date}'";
							$result2 = $conn->query($sql2);
							$details = $result2->fetch_assoc();
							
							$reportAppend .= $user['volunteer_id'] . ":" . $user['volunteer_fname'] . " " . $user['volunteer_lname'] ."<br>Clocked in at: " . $lineDB . "<br>In Department: " . $details['calendar_dept'] . "<br>for " . $details['calendar_shift'] . " shift.<br><br>";
							fclose($reading); 
					}
				}
				
				echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
				
			}break;
			case "report3":
			{
				//single day values
				$sun_value= date('d', strtotime('Sunday this week'));
				$mon_value= date('d', strtotime('Monday this week'));
				$tue_value= date('d', strtotime('Tuesday this week'));
				$wed_value= date('d', strtotime('Wednesday this week'));
				$thu_value= date('d', strtotime('Thursday this week'));
				$fri_value= date('d', strtotime('Friday this week'));				
				$sat_value= date('d', strtotime('Saturday this week'));		

				$dateArray =
				//yy-mm-dd for database comparison
				array(
				"mon"=> date('y-m-d', strtotime('Monday this week')),
				"tue"=> date('y-m-d', strtotime('Tuesday this week')),
				"wed"=> date('y-m-d', strtotime('Wednesday this week')),
				"thu"=> date('y-m-d', strtotime('Thursday this week')),
				"fri"=> date('y-m-d', strtotime('Friday this week')),			
				"sat"=> date('y-m-d', strtotime('Saturday this week')),
				"sun"=> date('y-m-d', strtotime('Sunday this week')));


				
				$reportAppend = "";
				
				$reportAppend .= "<div class=" . '"calFormatVol"' . ">". $mon_value ."</div><div class=" . '"calFormatVol"' .  ">". $tue_value ."</div><div class=" . '"calFormatVol"' .  ">". $wed_value ."</div><div class=" . '"calFormatVol"' .  ">". $thu_value ."</div><div class=" . '"calFormatVol"' .  ">". $fri_value ."</div><div class=" . '"calFormatVol"' .  ">". $sat_value ."</div><div class=" . '"calFormatVol"' .  ">". $sun_value ."</div> ";
				
				
				
				
				foreach($dateArray as $currDay => $value)
				{
					$sql = "select volunteer_id, calendar_dept, calendar_shift from calendar_entry where calendar_date='". $value ."' AND crossed_out='0'";
					$result = $conn->query($sql);
					

					
					$reportAppend .= "<div class=" . '"calFormatVol"' . ">";
					while($row = $result->fetch_assoc())
					{
						$sqlJoin = "select volunteer_fname, volunteer_lname from volunteer where volunteer_id=" . $row['volunteer_id'] . "";
						$resultJoin = $conn->query($sqlJoin);
						$rowJoin = $resultJoin->fetch_assoc();
						
						
						$reportAppend .= $rowJoin['volunteer_fname'] . " " . $rowJoin['volunteer_lname'] ."<br>" . $row['calendar_dept'] . "<br> " . $row['calendar_shift'] . "<hr><br>";
					} 
					
					$reportAppend .= "</div>";
				}

				echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
			}break;
			case "report4":
			{	
			}break;
			case "report5":
			{	
			}break;
			case "report6":
			{	

				if(isset($_POST['reportType']))
				{
					if(isset($_POST['paramInclude']))
					{
						if($_POST['paramInclude'] == "Gender")
						{
							$reportAppend = "";
							$sql = "select volunteer_gender from volunteer";
							$result = $conn->query($sql);
							$recordCount = $result->num_rows;
							$rowCountMale = 0;
							$rowCountFemale = 0;
							
							while($row = $result->fetch_assoc())
							{
								if($row['volunteer_gender'] == "male")
								{
									$rowCountMale++;
								}
								else
								{
									$rowCountFemale++;
								}
							}
							
							$reportAppend .= "Male: ". round((($rowCountMale / $recordCount) * 100)) . "%<br>Female: ". round((($rowCountFemale / $recordCount) * 100)) ."%";
							echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";	
						}
						else if($_POST['paramInclude'] == "Age")
						{
							$reportAppend = "";
							$sql = "select volunteer_birthdate from volunteer";
							$result = $conn->query($sql);
							$currDate = "" . date('Y') . "-" . date('m') . "-". date('d') ."";
							$ageArray = array();
							$ageCounterArray = array();
							
							$ageCounterArray = array_fill(0, 4, 0);
							
							$today = date_create_from_format('Y-m-d', $currDate);
							
							while($row = $result->fetch_assoc())
							{
								
								$birthday = date_create_from_format('Y-m-d', $row['volunteer_birthdate']);
								$diff=date_diff($today,$birthday);
								$math = $diff->format("%R%a days");
								$math = abs(round($math / 365));
								array_push($ageArray, $math);
							}
							
							for($i = 0; $i < sizeof($ageArray); $i++)
							{
								if($ageArray[$i] >= 0 && $ageArray[$i] <= 14)
								{
									$ageCounterArray[0] += 1;
								}
								else if($ageArray[$i] >= 15 && $ageArray[$i] <= 24)
								{
									$ageCounterArray[1] += 1;
								}
								else if($ageArray[$i] >= 25 && $ageArray[$i] <= 64)
								{
									$ageCounterArray[2] += 1;
								}
								else if($ageArray[$i] >= 65)
								{
									$ageCounterArray[3] += 1;
								}
							}
							
							for($j = 0; $j < sizeof($ageCounterArray); $j++)
							{
								if($j == 0)
								{
									$reportAppend .= "Children(0-14): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) . "%<br>";
								}
								else if($j == 1)
								{
									$reportAppend .= "Youth(15-24): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) .  "%<br>";
								}
								else if($j == 2)
								{
									$reportAppend .= " Adults(25-64): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) .  "%<br>";
								}
								else if($j == 3)
								{
									$reportAppend .= "Seniors(65+): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) . "%<br>";
								}
							}

							echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
						}
						else if($_POST['paramInclude'] == "Both")
						{
							$reportAppend = "";
							$sql = "select volunteer_gender from volunteer";
							$result = $conn->query($sql);
							$recordCount = $result->num_rows;
							$rowCountMale = 0;
							$rowCountFemale = 0;
							
							while($row = $result->fetch_assoc())
							{
								if($row['volunteer_gender'] == "male")
								{
									$rowCountMale++;
								}
								else
								{
									$rowCountFemale++;
								}
							}

							$sql = "select volunteer_birthdate from volunteer";
							$result = $conn->query($sql);
							$currDate = "" . date('Y') . "-" . date('m') . "-". date('d') ."";
							$ageArray = array();
							$ageCounterArray = array();
							
							$ageCounterArray = array_fill(0, 4, 0);
							
							$today = date_create_from_format('Y-m-d', $currDate);
							
							while($row = $result->fetch_assoc())
							{
								
								$birthday = date_create_from_format('Y-m-d', $row['volunteer_birthdate']);
								$diff=date_diff($today,$birthday);
								$math = $diff->format("%R%a days");
								$math = abs(round($math / 365));
								array_push($ageArray, $math);
							}
							
							for($i = 0; $i < sizeof($ageArray); $i++)
							{
								if($ageArray[$i] >= 0 && $ageArray[$i] <= 14)
								{
									$ageCounterArray[0] += 1;
								}
								else if($ageArray[$i] >= 15 && $ageArray[$i] <= 24)
								{
									$ageCounterArray[1] += 1;
								}
								else if($ageArray[$i] >= 25 && $ageArray[$i] <= 64)
								{
									$ageCounterArray[2] += 1;
								}
								else if($ageArray[$i] >= 65)
								{
									$ageCounterArray[3] += 1;
								}
							}
							
							for($j = 0; $j < sizeof($ageCounterArray); $j++)
							{
								if($j == 0)
								{
									$reportAppend .= "Children(0-14): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) . "%<br>";
								}
								else if($j == 1)
								{
									$reportAppend .= "Youth(15-24): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) .  "%<br>";
								}
								else if($j == 2)
								{
									$reportAppend .= " Adults(25-64): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) .  "%<br>";
								}
								else if($j == 3)
								{
									$reportAppend .= "Seniors(65+): " . round(($ageCounterArray[$j]/  (sizeof($ageArray))) * 100) . "%<br><br>";
								}
							}
							
							$reportAppend .= "Male: ". round((($rowCountMale / $recordCount) * 100)) . "%<br>Female: ". round((($rowCountFemale / $recordCount) * 100)) ."%";
							echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
						}
					}
				}
			}break;
			case "report7":
			{	
				$acceptedParams = array();
				$acceptedParams2 = array();
				$acceptedParams3 = array();
				$arrayCounter = array();
				$arrayCounter2 = array();
				
				//print_r($_POST);
				if(isset($_POST['reportType']))
				{
					$reportAppend = "";
					$report;
					$sqlAvail = "select volunteer_fk from pref_avail where ";
					$sqlDept = "select volunteer_fk from pref_dept where ";
					
					
					if(isset($_POST['am']))
					{
						$morning = "am='yes'";
						array_push($acceptedParams3, $morning);
					}
					if(isset($_POST['pm']))
					{
						$Afternoon = "pm='yes'";
						array_push($acceptedParams3, $Afternoon);
					}
					if(isset($_POST['monday']))
					{
						$Monday = "weekday='monday'";
						array_push($acceptedParams, $Monday);	
					}
					if(isset($_POST['tuesday']))
					{
						$Tuesday = "weekday='tuesday'";
						array_push($acceptedParams, $Tuesday);	
					}
					if(isset($_POST['wednesday']))
					{
						$Wednesday = "weekday='wednesday'";
						array_push($acceptedParams, $Wednesday);	
					}
					if(isset($_POST['thursday']))
					{
						$Thursday = "weekday='thursday'";
						array_push($acceptedParams, $Thursday);	
					}
					if(isset($_POST['friday']))
					{
						$Friday = "weekday='friday'";
						array_push($acceptedParams, $Friday);	
					}					
					if(isset($_POST['front']))
					{
						$front = "department='front' AND allow='yes'";
						array_push($acceptedParams2, $front);						
					}
					if(isset($_POST['vio']))
					{
						$vio = "department='vio' AND allow='yes'";
						array_push($acceptedParams2, $vio);						
					}
					if(isset($_POST['kitchen']))
					{
						$kitchen = "department='kitchen' AND allow='yes'";
						array_push($acceptedParams2, $kitchen);						
					}
					if(isset($_POST['warehouse']))
					{
						$warehouse = "department='warehouse' AND allow='yes'";
						array_push($acceptedParams2, $warehouse);						
					}
				}
					if(sizeof($acceptedParams3) == 0 || sizeof($acceptedParams2) == 0 || sizeof($acceptedParams) == 0)
					{
						echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = 'Please ensure at least one of each field is selected.' };</script>";
					}
					else
					{
						for($i = 0; $i < sizeof($acceptedParams); $i++)
						{
							$sqlAvail = "select volunteer_fk from pref_avail where {$acceptedParams[$i]} AND ";
								if(sizeof($acceptedParams3) == 1)
								{
									if(isset($_POST['am']))
									{
										$sqlAvail .= "{$morning};";
									}
									if(isset($_POST['pm']))
									{
										$sqlAvail .= "{$Afternoon};";
									}
								}
								else
								{
									$sqlAvail .= "{$morning} AND {$Afternoon}";
								}
							$result = $conn->query($sqlAvail);
							while($row = $result->fetch_assoc())
							{
								array_push($arrayCounter, $row['volunteer_fk']);
							}
						}
					}
					
					for($i = 0; $i < sizeof($acceptedParams2); $i++)
					{
						$sqlDept = "select volunteer_fk from pref_dept where {$acceptedParams2[$i]} AND volunteer_fk='{$arrayCounter[$i]}'";
						$result = $conn->query($sqlDept);
							while($row = $result->fetch_assoc())
							{
								array_push($arrayCounter2, $row['volunteer_fk']);
							}
					}
					
					for($i = 0; $i < sizeof($arrayCounter2); $i++)
					{
						$sql = "select volunteer_fname, volunteer_lname from volunteer where volunteer_id='{$arrayCounter2[$i]}'";
						$result = $conn->query($sql);
							while($row = $result->fetch_assoc())
							{
								$reportAppend .= $row['volunteer_fname'] . " " . $row['volunteer_lname'] . "<br>";
							}
					}
									
					echo "<script> window.onload = function() {document.getElementById('PrintHere').innerHTML = '$reportAppend' };</script>";
				
			}break;
			default:
			{
				echo "SRY BUT NO";
			}break;
		}
	}
	
	
	
}



?>
<script>
function printReport()
{
	
	document.getElementById('reportsFrame').innerHTML = 'test';
	
}



</script>
<script>
function generateParameterFields(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("PrintHere").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ReportParameters.php?q=" + str, true);
        xmlhttp.send();
}
</script>
<script>
function testFunc(isSelected, inputVal)
{
	if(isSelected == true && inputVal == "show")
	{
		document.getElementById('ShowSpecificParams').hidden = false;
	}
	else
	{
		document.getElementById('ShowSpecificParams').hidden = true;
	}
}
</script>
<script>
function populateList(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("List").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "/Foodbank/Calendar/populateList.php?q=" + str, true);
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
		$(document).change(function() {
			$('.test').select2({ width: '200px' });
		});	
	</script>

<html>
	<head>
		<title>Reports</title>
		<link rel="stylesheet" type="text/css" href="/Foodbank/css/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="reports.css">
	</head>
	
	<body class="wrapper">
	<form id="selectReport" action="" method="POST">
		<h1><a href="/Foodbank/Admin/home.php"><img id="logo" src="/Foodbank/images/logo.gif"></a><a href="reports.php">Reports</h1></a>
	<div id="topRightNav">
	<a href="/Foodbank/TimeClock/index.php">Time Clock</a>
		<a href="/Foodbank/Admin/logout.php" class="loginButton">Logout</a>
	</div>

	<div id="mainNav">
		<ul>
			<li><a href="/Foodbank/Admin/home.php">Home</a></li>
			<li><a href="/Foodbank/Calendar/">Calendar</a></li>
			<li>
				<a>Manage Volunteers</a>
				<ul class="dropdown">
					<li><a href="/Foodbank/Volunteer/newVolunteer.php">New Volunteer</a></li>
					<li><a href="/Foodbank/Volunteer/updateVolunteer.php">Update Volunteer</a></li>
					<li><a href="#">Update Time Entries</a></li>
				</ul>
			</li>
			<li class="active"><a href="/Foodbank/Reports/reports.php">Reports</a></li>
		</ul>
	</div>

		<div class="container">
			
			<!-- TODO: Finish these reports -->
				<select id="reportType" name="reportType" onChange="generateParameterFields(this.value)">
					<option value="" disabled selected>Select a Report to Generate</option>
					<option value="report1">Volunteer Contact Info</option>  <!-- display all volunteers contact info, params all or inactive or specific? -->
					<option value="report2">Currently On-Site</option>  <!-- requires Justins shit -->
					<option value="report3">Weekly Schedule</option>  <!-- single -->
					<option value="report4">Total Hours Worked For Individual Volunteer</option>  <!--params all time, specified time, individual -->
					<option value="report5">Total Hours worked For All Volunteers</option>  <!-- params: all time, specified time -->
					<option value="report6">Demographics</option>  <!-- params ages, gender -->
					<option value="report7">Available Volunteers</option>  <!-- active only params specific shift, department, days -->
				</select>
				<input type="Submit" value="Generate Report">
			
		</div>
		
		<div id="reportsFrame" style="overflow: auto;">
		<div id="PrintHere"></div>
			
		
		</div>
		</form>
	</body>
</html>