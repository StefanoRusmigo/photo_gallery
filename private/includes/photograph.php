<?php
require_once(LIB_PATH.DS.'initialize.php');

class Photograph extends DatabaseObject{
	protected static $table_name="photographs";
	protected static $db_fields = array('filename','type','size','caption');
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;

	private $temp_path;
	protected $upload_dir = "images";
	public $errors = array();

	protected $upload_errors = array(
			// http://www.php.net/manual/en/features.file-upload.errors.php
	  UPLOAD_ERR_OK 				=> "No errors.",
	  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);

	public function attach_file($file){
		if(!$file || empty($file) || !is_array($file)){
			$this->errors[] = "No file was uploaded";
			return false;
		}elseif ($file['error']!=0) {
			$this->errors[] = $this->upload_errors[$file['error']];
			return false; 
		}else{
			$this->temp_path = $file['tmp_name'];
			$this->filename = basename($file['name']);
			$this->type = $file['type'];
			$this->size = $file['size'];

			return true;
		}


	}

	public function save() {
		// A new record won't have an id yet.
		if(isset($this->id)) {
			// Really just to update the caption
			$this->update();
		} else {
			// Make sure there are no errors
			
			// Can't save if there are pre-existing errors
		  if(!empty($this->errors)) { return false; }
		  
		 
		  // Can't save without filename and temp location
		  if(empty($this->filename) || empty($this->temp_path)) {
		    $this->errors[] = "The file location was not available.";
		    return false;
		  }
			
			// Determine the target_path
		  $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;
		  
		  // Make sure a file doesn't already exist in the target location
		  if(file_exists($target_path)) {
		    $this->errors[] = "The file {$this->filename} already exists.";
		    return false;
		  }
		
			// Attempt to move the file 
			if(move_uploaded_file($this->temp_path, $target_path)) {
		  	// Success
				// Save a corresponding entry to the database
				if($this->create()) {
					// We are done with temp_path, the file isn't there anymore
					unset($this->temp_path);
					return true;
				}
			} else {
				// File was not moved.
		    $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
		    return false;
			}
		}
	}

	public function destroy()
	{
		if($this->delete()){
		  $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;
		  return unlink($target_path) ? true : false;
		}
		else{ return false;}
	}



	public function size_text(){
		$size = $this->size;
		if($size < 1024){
			return "{$size} bytes";
		}elseif ($size < 1048576) {
			$kbsize = round($size/1024);
			return "{$kbsize} KB";
		}else{
			$mbsize = round($size/1048576,1);
			return "{$mbsize} MB";
		}
	}


}

?>