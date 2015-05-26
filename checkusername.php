<?php
	include_once("database.php");
	$myDB = new Database;
	$myDB->openDatabase();
	$number;
	
	$username = $myDB->escapeString($_POST["username"]);
	$result = $myDB->selectQueryWhere("username", "users", "username = '" . $username . "'");

	if ($result->num_rows > 0)
	{
		$number = 0;
	}
	else
	{
		$number = 1;
	}
	
	$myDB->closeDatabase();
	echo $number;
?>