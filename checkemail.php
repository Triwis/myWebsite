<?php
	include_once("database.php");
	$myDB = new Database;
	$myDB->openDatabase();
	$number;
	
	$email = $myDB->escapeString($_POST["email"]);
	$result = $myDB->selectQueryWhere("email", "users", "email = '" . $email . "'");

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