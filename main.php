<?php
	include_once("user.php");
	session_start();
	$user = $_SESSION["user"];
	
	//admin userss
	if ($user!= NULL && $user->getAuthLevel() === 1)
	{
		header("location: /admin/masterpage.php");
		die();
	}
	//for now... only admins can do things...
	else
	{
		session_unset();
		header("location: ../login.php");
		die();
	}
?>