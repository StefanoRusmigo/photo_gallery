<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<html>
<?php include_layout_template('admin_header.php') ?>

    <div id="main">
		<h2>Menu</h2>
        <?php echo output_message($message);  ?>

		<ul>
    <li><a href="logs.php">logs</a></li>  
    <li><a href="logout.php">logout</a></li>  
    <li><a href="gallery.php">gallery</a></li>  
    </ul>
		</div>
<?php include_layout_template('admin_footer.php') ?>
