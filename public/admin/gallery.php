<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php $photos = Photograph::all(); ?>
<html>
<?php include_layout_template('admin_header.php') ?>
<?php echo output_message($message);  ?>
<table class="bordered">
	<tr>
		<th>Image</th>
		<th>Filename</th>
		<th>Caption</th>
		<th>Size</th>
		<th>Type</th>
		<th>&nbsp;</th>
	</tr>

 <?php  foreach ($photos as $photo): ?>

 	<tr>
 		<td><img src="../images/<?php echo $photo->filename; ?>" width="100"></td>	
 		<td><?php echo $photo->filename; ?></td>	
 		<td><?php echo $photo->caption; ?></td>	
 		<td><?php echo $photo->size_text(); ?></td>	
 		<td><?php echo $photo->type; ?></td>	
 		<td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">delete</a></td>	
 	</tr>

  <?php endforeach; ?>

</table>

<a href="photo_upload.php">Upload a photo</a>


<?php include_layout_template('admin_footer.php') ?>
		
