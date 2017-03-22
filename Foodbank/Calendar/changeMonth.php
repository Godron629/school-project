<?php
session_start();


if($_GET['btn'] == "back")
{
	$_SESSION['currMonth'] = $_GET['q'] - 1;
}
else
{
	$_SESSION['currMonth'] = $_GET['q'] + 1;
}

?>