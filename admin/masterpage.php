<?php
	include_once('../user.php');
	session_start();
	
	$user = $_SESSION["user"];
	if ($user == NULL || $user->getAuthLevel() !== 1)
	{
		session_unset();
		header("location: ../login.php");
		die();
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/myStyle.css">
	</head>
	<body>
		<div class="bold">
			TO DO LIST: <br />
			- Implement the TO DO LIST on separate webpage <br />
			- Move the client side javascript verification on the login page to a sepate js file  (or remove it? server side validation works anyway)<br />
			- Design a new nice UI <br />
			- Redisgn the login page and change texts on the login page <br />
			- Create the new main page <br />
			- Implement the sendEmail to admin(s) when new users register <br />
			- Implement the sendEmail to user when accepted <br />
			- Implement the self-signed certificate for login page and https <br />
		</div>
		<br />
		<div class="bold">
			Admin Fonctions: 
		</div>
		<a href="newuserslist.php">View new users</a>
		<br />
		<a href="../logout.php">Logout</a>
	</body>
</html>