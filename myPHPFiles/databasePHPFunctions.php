<?php

/*
* Gideon Richter 2/22/2017
* These functions allow a programmer to interact with a mysql database
*/

function db_connect() {

	//Static so connection remains between calls
	static $connection;

	//Connect to database if not connected
	if(!isset($connection)) {
		//.ini file must be manually created
		$config = parse_ini_file('../../config.ini');
		$connection = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
	}

	//Unsuccessful connection
	if($connection === false) {
		return $connection->connect_error;
	}
	return $connection;
}

function db_query($query) {
	$connection = db_connect();
	$result = $connection->query($query);

	if($result === false) {
		return db_error();
	}
	return $result;
}

//Returns array of arrays with results
function db_select($query) {
	$connection = db_connect();
	$result = db_query($query);
	$rows = array();

	if($result === false) {
		echo "Bad query: " . db_error();
		return false;
	} else {
		var_dump($result);
		while($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}
	}
	return $rows;
}

function db_error() {
	$connection = db_connect();
	return $connection->error;
}

//Escape values for user input
function db_quote($value) {
	$connection = db_connect();
	return "'" . $connection->real_escape_string($value) . "'";
}
	
?>