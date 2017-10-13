<?php
require_once('../../private/includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<html>
<?php include_layout_template('admin_header.php') ?>
  <body>
    <div id="header">
      <h1>Photo Gallery</h1>
    </div>
    <div id="main">
		<h2>Menu</h2>
		
		</div>
<?php include_layout_template('admin_footer.php') ?>
		
  </body>
</html>
