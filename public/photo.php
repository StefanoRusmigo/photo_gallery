<?php require_once('../private/includes/initialize.php'); ?>

<?php include_layout_template('header.php'); ?>

<?php 

	if( empty($_GET['id']) || !($photo = Photograph::find($_GET['id']))) {
		$session->message("Photo could not be found");
		redirect_to('index.php');
	}

	if(isset($_POST['submit'])){
		$author = $_POST['author'];
		$body = $_POST['body'];
		$comment = Comment::build($photo->id,$author,$body);

		if($comment->save()){

			$comment->send_email();

			redirect_to("photo.php?id={$photo->id}");

		}else{
			$message =" There was an error saving your commment";
		}
		

	}else{
		$author="";
		$body="";
	}

    $comments = $photo->comments(); 

?>
<a href="index.php">&laquo; Back</a> </br></br>


  <div style="margin-left: 20px;">
		
			<img src="images/<?php echo $photo->filename; ?>" />
		
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
  		</div>
  	<?php endforeach; ?>
  	<?php if(empty($comments)){echo "no comments";} ?>

  </div>


  

  

<div id="comment-form">
	<h3>New Comment</h3>
  	<?php echo output_message($message); ?>
  <form action="photo.php?id=<?php echo $photo->id; ?>" method="POST">
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="author" value="<?php echo $author; ?>"></td>
		</tr>

		<tr>
			<td>Comment:</td>
			<td><textarea name="body" cols="40" rows="8" value="<?php echo $body;?>"></textarea></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit"></td>
		</tr>
	</table>
  </form>

</div>
  	
  	
  	
  	
    
  	



<?php include_layout_template('footer.php'); ?>
