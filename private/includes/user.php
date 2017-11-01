<?php
require_once(LIB_PATH.DS.'initialize.php');

class User extends DatabaseObject {
	protected static $table_name="users";
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;

	
	public static function authenticate($username="", $password="")
	{
		global $database;

		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		$sql = "SELECT * FROM users 
				WHERE username='{$username}' and
					  password='{$password}'
					  LIMIT 1";
		$result = self::find_by_sql($sql);
		return !empty($result) ? array_shift($result) : false; 


	}

	

	public function full_name()
	{
		if(isset($this->first_name) && isset($this->last_name)){
			return $this->first_name." ".$this->last_name;
		}else {
			return "";
		}
		
	}

	public function create()
	{
		global $database;
		$database->escape_value($this->username);

		$sql = "INSERT INTO users (";
	  	$sql .= "username, password, first_name, last_name";
	  	$sql .= ") VALUES ('";
		$sql .= $database->escape_value($this->username) ."', '";
		$sql .= $database->escape_value($this->password) ."', '";
		$sql .= $database->escape_value($this->first_name) ."', '";
		$sql .= $database->escape_value($this->last_name) ."')";

		if($database->query($sql)){
			$this->id = insert_id();
			return true;

		}else{
			return false;
		}
	}



}

?>