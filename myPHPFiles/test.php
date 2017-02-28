<?php include 'databasePHPFunctions.php';
	$connection = db_connect();

	echo removeSymbolsFromPhone("(403) 932 -      1  9810");

	function removeSymbolsFromPhone($phone) {
       $phone = preg_replace("([^0-9]+)", "", $phone);
       return $phone;
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
</head>
<body>

</body>
</html>