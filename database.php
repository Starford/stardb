<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
class Database {
	private $connection;//this value will store the connection object
	public function __construct($connection_array)
	{
		if (count($connection_array) == 4)://if the size of the array is 4 continue
				//echo $connection_array['server'];
				$con = mysqli_connect($connection_array['server'], $connection_array['username'], $connection_array['password'], $connection_array['db']);
				if(!$con):
					//exit();
					throw new Exception('Error: error number = '.mysqli_connect_errno());
				else:
					$this->connection =  $con;
				endif;
		else://the array is incomplete
			exit();
			throw new Exception('Error: Incomplete Connection Configurations');
		endif;
	}
	public function loadResult($query){
		if(empty($query)): throw new Exception('No Query'); endif;
		$connection = $this->connection;
		$result = $connection->query($query);
		if (!$connection->errno):
			$row = mysqli_fetch_object($result);
			return $row;
			mysqli_free_result($result);
		else:
			return $connection->errno.': '.$connection->error;
		endif;
		$connection->close();
	}
	public function loadResults($query){
		if(empty($query)): throw new Exception('No Query'); endif;
		$connection = $this->connection;
		$result = $connection->query($query);
		if (!$connection->errno):
			if($result):
					$function_result = array();
					$i = 0;
					while($row = $result->fetch_object()){

					$function_result[] = $row;
					$i++;
					}
					mysqli_free_result($result);
					return $function_result;
			endif;
		else:
			throw new Exception($connection->errno.': '.$connection->error);
			//return $connection->errno.': '.$connection->error;
		endif;
		$connection->close();
	}
	public function insertSql($query){
		if(empty($query)): throw new Exception('No Query'); endif;
		$connection = $this->connection;
		$connection->query($query);
		if (!$connection->errno):
			return mysqli_insert_id($connection);
		else:
			throw new Exception($connection->errno.': '.$connection->error);
			//return $connection->errno.': '.$connection->error;
		endif;
	}
	public function updateSql($query){
		if(empty($query)): throw new Exception('No Query'); endif;
		$connection = $this->connection;
		$connection->query($query);
		if (!$connection->errno):
			return 1;
		else:
			throw new Exception($connection->errno.': '.$connection->error);
			//return $connection->errno.': '.$connection->error;
		endif;
	}

}
 ?>
