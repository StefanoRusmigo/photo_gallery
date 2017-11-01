<?php
require_once('initialize.php');

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
    die("The file {$class_name}.php could not be found.");
  }
}

function include_layout_template($template=""){

  include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}



function log_action($action, $message=""){
  $file = SITE_ROOT.DS.'private'.DS.'logs'.DS.'log.txt';

 if($handle = fopen($file, 'a')){

  $data = strftime("%Y-%m-%d %H:%M:%S",time())." | ".$action.": ".$message."\n";

  fwrite($handle, $data);

  fclose($handle);
 }
 }

 function log_read(){
  $file = SITE_ROOT.DS.'private'.DS.'logs'.DS.'log.txt';
 if ($handle = fopen($file, 'r')){
  return file_get_contents($file);
  fclose($handle);

 }
}

 function log_clear(){
  $file = SITE_ROOT.DS.'private'.DS.'logs'.DS.'log.txt';

file_put_contents($file, "");

}


?>