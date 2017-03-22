<?php
session_start();

if($_GET['q'] == "Kitchen")
{
	$_SESSION['calDept'] = "Kitchen";
}
else if($_GET['q'] == "Volunteer Intake Coordinator")
{
	$_SESSION['calDept'] = "Volunteer Intake Coordinator";
}
else if($_GET['q'] == "Front")
{
	$_SESSION['calDept'] = "Front";
}
else
{
	$_SESSION['calDept'] = "Warehouse";
}


?>