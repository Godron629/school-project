<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/php/formValidation.php";

	$test ="He@@llo   my frie*()nd";
	$test = onlyKeepCharacters($test);

	echo $test;

?>

