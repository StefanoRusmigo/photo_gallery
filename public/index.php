<?php require_once('../private/includes/initialize.php'); ?>
<?php
	$page = !empty($_GET['page']) ? $_GET['page'] : 1 ;
	$per_page = 10;
	$total_count = Photograph::count_all();
	$pagination = new Pagination($page,$per_page,$total_count);
	$photos = Photograph::pagination($page,$per_page);
	
?>

<?php include_layout_template('header.php'); ?>

<?php foreach($photos as $photo): ?>
  <div style="float: left; margin-left: 20px;">
		<a href="photo.php?id=<?php echo $photo->id; ?>">
			<img src="images/<?php echo $photo->filename; ?>" width="200" />
		</a>
    <p><?php echo $photo->caption; ?></p>
  </div>
<?php endforeach; ?>

<div class="pagination" style="clear:both;">

	<?php 
	if($pagination->total_pages() >1){

		if($pagination->has_previous_page()){
			echo " <a href=\"index.php?page={$pagination->previous_page()}\">&laquo; Previous</a> ";
		}

	  for($i=1; $i<=$pagination->total_pages(); $i++){
	  	if($i == $page){
	  		echo " <span class=\"selected\">{$i}</span> ";
	  	}else{
	  		echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
	  	}
	  }

	  if($pagination->has_next_page()){
			echo " <a href=\"index.php?page={$pagination->next_page()}\">Next &raquo;</a> ";
		}

	}

	?>

</div>


<?php include_layout_template('footer.php'); ?>
