<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<html>
<?php include_layout_template('admin_header.php') ?>
 
    <div id="main">
		<h2>Logs</h2>
		
			<?php 
			if (isset($_GET['clear']) && $_GET['clear']  == true){
				log_clear();
				redirect_to('logs.php');
			}
			$content = log_read();
			echo "<h4>".nl2br($content)."</h4>";
			?>

			<a href="logs.php?clear=true">clear</a>
		
		</div>
<?php include_layout_template('admin_footer.php') ?>
		
  </body>
</html>
