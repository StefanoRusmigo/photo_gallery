<?php
require_once('../private/includes/initialize.php');
 $user = User::find(1);
 echo $user->full_name();

$users = User::all();
echo "<hr>";
foreach ($users as $user) {
	echo $user->full_name()."<br/>";
}

$user = new User;
$user->username = "Tests";
$user->password = "passs";
$user->first_name = "Giws";
$user->last_name = "rgoss";
$user->create();
?>