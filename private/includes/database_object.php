<?php
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {

	

	public static function all()
	{	
		$sql = "SELECT * FROM ".static::$table_name;
		return self::find_by_sql($sql);
	}

	public static function find($id)
	{
		$sql = "SELECT * FROM ".static::$table_name." WHERE id={$id} LIMIT 1";
		$result = self::find_by_sql($sql);
		return !empty($result) ? array_shift($result) : false; 

		
	}

public static function find_by_sql($sql)
	{
		global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
	}

public static function instantiate($record)
	{
		$class_name = get_called_class();
		$object = new $class_name ;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		
		return $object;
	}




	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = get_object_vars($this);
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}
}