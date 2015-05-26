<?php
	include_once("../users.php");
	
	$id = $_POST["id"];
	$authLevel = $_POST["authLevel"];
	$isActive = $_POST["isActive"];
	
	$x = Users::setNewUser($id, $authLevel, $isActive);
	echo $x;
?>