<?php require_once('../private/includes/initialize.php'); ?>

<?php include_layout_template('header.php'); ?>

<?php 

	if( empty($_GET['id']) || !($photo = Photograph::find($_GET['id']))) {
		$session->message("Photo could not be found");
		redirect_to('index.php');
	}
?>
<a href="index.php">&laquo; Back</a> </br></br>


  <div style="margin-left: 20px;">
		
			<img src="images/<?php echo $photo->filename; ?>" />
		
    <p><?php echo $photo->caption; ?></p>
  </div>


<?php include_layout_template('footer.php'); ?>
