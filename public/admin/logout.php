<?php
require_once('../../private/includes/initialize.php');

$session->logout();
redirect_to('login.php');
?>