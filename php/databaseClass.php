<?php 

class database {
	protected static $connection;

	public function connect() {
		if(!isset(self::$connection)) {
			$config = parse_ini_file('../../config.ini');
			self::$connection = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname'], $config['port']);
		}

		if(self::$connection === false) {
			throw new Execption("Hello this is an exeption");
		}

		return self::$connection;
	}

	public function query($query) {
		$connection = $this->connect();

		//mysqli function query
		$result = $connection->query($query); 

		return $result;
	}

	public function select($query) {
		$rows = array();
		$results = $this->query($query);

		if($results === false) {
			return false;
		}

		while($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}

		return $rows;
	}

	public function error() {
		$connection = $this->connect();
		return $connection->error;
	}

	public function quote($value) {
		$connection = $this->connect();
		return "'" . $connection->real_escape_string($value) . "'";
	}
}
	
?>