<?php  
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }

if( !empty($_GET['id']) && $photo = Photograph::find($_GET['id'])){
	if($photo->destroy()){
		$session->message("Photo {$photo->filename} deleted succesfully");
		redirect_to('gallery.php');
	}else{
		$session->message("Photo {$photo->filename} could not be deleted");
		redirect_to('gallery.php');
	}
}else{
		$session->message("Photo could not be found");
		redirect_to('gallery.php');
}

?>

<?php 
// because no footer layout to close the connenction we close manually even thought it closes by it self its good practice
if(isset($database)) { $database->close_connection(); } ?>