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
		global $database;
		$sql = "SELECT * FROM ".static::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1";
		$result = self::find_by_sql($sql);
		return !empty($result) ? array_shift($result) : false; 

		
	}

	public static function count_all(){
		global $database;

		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$row = $database->query($sql);
		$result = $database->fetch_array($row);
		return array_shift($result);
	}



public static function find_by_sql($sql,$class_name=null)
	{
		global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row,$class_name);
    }
    return $object_array;
	}

public static function instantiate($record,$class_name)
	{

		$class_name = isset($class_name)? $class_name  : get_called_class();
		$object = new $class_name ;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		
		return $object;
	}

	public  function save()
	{
		return isset($this->id) ? $this->update() : $this->create();

	}

	

	protected function attributes()
	{
		$attributes = array();
		foreach (static::$db_fields as $field) {
			if(property_exists($this, $field)) {
			$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}

	protected function sanitized_attributes(){
		 global $database;

		$clean_attributes = array();

		 foreach ($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $database->escape_value($value);
		 }
		 return $clean_attributes;
	}


	public function create()
	{
		global $database;
		 $attributes = $this->sanitized_attributes();

		$sql = "INSERT INTO ".static::$table_name." (";
	  	$sql .= join(", ", array_keys($attributes));
	  	$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes)) ."')";
		if($database->query($sql)){
			echo $this->id = $database->insert_id();
			return true;

		}else{
			return false;
		}
	}


	public function update()
	{
		global $database;
		$attributes = $this->sanitized_attributes();
		$attributes_pairs = array();
		foreach ($attributes as $key => $value) {
			$attributes_pairs[] = "{$key} = '{$value}'";
		}
		
		$sql = "UPDATE users SET ";
		$sql .= join(", ", $attributes_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);

		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;



	}

	public function delete()
	{
		global $database;

		$sql = "DELETE FROM ".static::$table_name;
		$sql.= " WHERE id=".$database->escape_value($this->id);
		$sql.= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}

	public function pagination($page,$per_page){
		$offset = $per_page *($page -1);
		$sql = "SELECT * FROM ".static::$table_name." LIMIT ".$per_page." OFFSET ".$offset;
		return self::find_by_sql($sql);

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