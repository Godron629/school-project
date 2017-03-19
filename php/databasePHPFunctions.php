<?php

function db_connect() {
	static $connection;

	if(!isset($connection)) {
		//.ini file must be manually created
		$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/config.ini");
		$connection = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
	}

	if($connection === false) {
		echo db_error();
		return false;
	}

	return $connection;
}

function db_query($query) {
	$connection = db_connect();
	$result = $connection->query($query);

	if($result === false) {
		echo "Query Error: " . db_error();
		return false;
	}

	return $result;
}

//Returns array of arrays with results
function db_select($query) {
	$rows = array();
	$result = db_query($query);

	if($result === false) {
		return false;
	} 
	
	while($row = $result->fetch_assoc()) {
		$rows[] = $row;	
	}

	return $rows;
}

function db_error() {
	$connection = db_connect();
	return $connection->error;
}

function db_quote($value) {
	$connection = db_connect();
	return "'" . $connection->real_escape_string($value) . "'";
}

?>