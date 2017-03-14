<?php
include $_SERVER['DOCUMENT_ROOT'] . "/php/formValidation.php";

$test = "Hel    l@o@@ my F*(&)riend";

echo regexForNames($test);
	
?>