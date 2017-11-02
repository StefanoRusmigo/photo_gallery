<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php  
$max_file_size = 10000000;

if(isset($_POST['submit'])){
	$photo = new Photograph;
	$photo->caption = $_POST['caption'];
	$photo->attach_file($_FILES['upload_file']);

	if($photo->save()){
		$session->message("The photo succesfully uploaded");
		redirect_to('gallery.php');
	}else{
		$message = join(", ", $photo->errors);
	}

}

 ?>
<html>
<?php include_layout_template('admin_header.php') ?>

   <h2>Photo Upload</h2>
<?php echo output_message($message);  ?>
<form action="photo_upload.php" method="POST" enctype="multipart/form-data">

	<p>
		<h4 style="margin-bottom: 0;"> Caption:</h4>
		<input type="text" name="caption" value="">
	</p>

	<input type="hidden"  name="MAX_FILE_SIZE" value= <?php echo $max_file_size ?> >
	<p><input type="file" name="upload_file"></p>
	
	
	<input type="submit" name="submit" value="upload">
</form>

<?php include_layout_template('admin_footer.php') ?>
		
