
<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php $photos = Photograph::all(); ?>
<html>
<?php include_layout_template('admin_header.php') ?>

<?php 

	if( empty($_GET['id']) || !($photo = Photograph::find($_GET['id']))) {
		$session->message("Photo could not be found");
		redirect_to('gallery.php');
	}

    $comments = $photo->comments(); 

?>
<a href="gallery.php">&laquo; Back</a> </br></br>
  	<?php echo output_message($message); ?>


  <div style="margin-left: 20px;">
		
			<img src="../images/<?php echo $photo->filename;  ?>" width="250" height="250"/>
		
    <p><?php echo $photo->caption; ?></p>
  </div>


  <div id="comments">
  	<?php foreach ($comments as $comment): ?>
  		<div class="comment" style="margin-bottom: 2 em;">
  			<div class="author">
  				
  				<?php echo htmlentities($comment->author); ?> wrote:
  			</div>
			<!-- -->
  			<div class="body">
  				<?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
  			</div>

  			<div class="meta-info" style="font-size: 0.8em;" >
  				<?php echo datetime_to_text($comment->created);  ?>
  			</div>

  			<div class="actions" style="font-size: 0,8em;">
  				<a href="delete_comments.php?id=<?php echo $comment->id; ?>">delete</a>
  				
  			</div>

  		</div>
  	<?php endforeach; ?>
  	<?php if(empty($comments)){echo "no comments";} ?>

  </div>


<?php include_layout_template('admin_footer.php') ?>
		
