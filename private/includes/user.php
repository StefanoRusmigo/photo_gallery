<?php
require_once(LIB_PATH.DS.'initialize.php');

class User extends DatabaseObject {
	protected static $table_name="users";
	protected static $db_fields = array('username','password','first_name','last_name');
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

	



}

?>