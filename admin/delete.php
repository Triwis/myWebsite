<?php
	include_once('../user.php');
	include_once('../parents/cadeaux.php');
	session_start();
	
	$user = $_SESSION["user"];
	if ($user == NULL || $user->getAuthLevel() !== 1)
	{
		session_unset();
		header("location: ../login.php");
		die();
	}
	
	$id = $_GET["id"];
	//var_dump($id);
	$id = (int)$id;
	Cadeaux::deleteAGift($id);
	header("location: modifylist.php");
	
?>