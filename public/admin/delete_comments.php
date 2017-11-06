<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }

	if(!empty($_GET['id'])){
		$comment = Comment::find($_GET['id']);
		$comment->delete();
		$session->message("Comment deleted");
		redirect_to("comments.php?id={$comment->photograph_id}");
	}else{
		$session->message("Cannot find comment id");
		redirect_to("gallery.php");
	}
if(isset($database)) { $database->close_connection(); } ?>
?>
