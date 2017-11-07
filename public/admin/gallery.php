<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php 
$page = !empty($_GET['page']) ? $_GET['page'] : 1 ;
	$per_page = 10;
	$total_count = Photograph::count_all();
	$pagination = new Pagination($page,$per_page,$total_count);
	$photos = Photograph::pagination($page,$per_page);

?>
<html>
<?php include_layout_template('admin_header.php') ?>
<?php echo output_message($message);  ?>
<a href="photo_upload.php">Upload a photo</a>
<table class="bordered">
	<tr>
		<th>Image</th>
		<th>Filename</th>
		<th>Caption</th>
		<th>Size</th>
		<th>Type</th>
		<th>Comment</th>
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
 		<td>
 			<a href="comments.php?id=<?php echo $photo->id ?>">
 			<?php echo count($photo->comments()); ?>
 			</a>
 		</td>


 	</tr>

  <?php endforeach; ?>

</table>



	

	
<div class="pagination" >

	<?php 
	if($pagination->total_pages() >1){

		if($pagination->has_previous_page()){
			echo " <a href=\"gallery.php?page={$pagination->previous_page()}\">&laquo; Previous</a> ";
		}

	  for($i=1; $i<=$pagination->total_pages(); $i++){
	  	if($i == $page){
	  		echo " <span class=\"selected\">{$i}</span> ";
	  	}else{
	  		echo " <a href=\"gallery.php?page={$i}\">{$i}</a> ";
	  	}
	  }

	  if($pagination->has_next_page()){
			echo " <a href=\"gallery.php?page={$pagination->next_page()}\">Next &raquo;</a> ";
		}
	}
	?>
</div>




<?php include_layout_template('admin_footer.php') ?>
		
