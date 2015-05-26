<?php
	include_once('../user.php');
	include_once('registeruser.php');
	session_start();
	
	$user = $_SESSION["user"];
	if ($user == NULL || $user->getAuthLevel() !== 1)
	{
		session_unset();
		header("location: ../login.php");
		die();
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["authlevel"]))
		{
			echo "Something went wrong!";
		}
		else
		{
			$username = sanitizeInput($_POST["username"]);
			$password = sanitizeInput($_POST["password"]);
			$password2 = sanitizeInput($_POST["password2"]);
			$authLevel = sanitizeInput($_POST["authlevel"]);
			
			if ($password !== $password2)
			{
				echo "Passwords do not match!";
			}
			else
			{
				$intAuthLevel = (int)$authLevel;
				if ($intAuthLevel === 0)
				{
					echo "Incorrect Authorization Level!";
				}
				else
				{
					RegisterUser::registerUser($username, $password, $intAuthLevel);
				}
			}
		}
	}
	
	function sanitizeInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
	<head>
	</head>
	<body>
		<form method="POST" id="createUser" name="createUser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Enter the information of the new user: <br />
			username: <input type="text" name="username" id="username" /> <br />
			password: <input type="password" name="password" id="password" /> <br />
			re-enter password: <input type="password" name="password2" id="password2" /> <br />
			authorization level: <input type="text" name="authlevel" id="authlevel" /> <br />
			<input type="submit" value="Submit" />
		</form>
	</body>
</html>