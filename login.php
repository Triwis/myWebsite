<?php
	session_start();
	session_unset();
	include_once('authentication.php');
	include_once('user.php');
	include_once('users.php');
	include_once('registeruser.php');
	$showErrorDiv = false;
	$errorMessage = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "login") 
	{
		$username = $_POST["usernameLog"];
		$password = $_POST["passwordLog"];
		
		$username = sanitizeInput($username);
		$password = sanitizeInput($password);
		$isAuthenticationSuccess = Authentication::authenticateUser($username, $password);
		var_dump($isAuthenticationSuccess);
		if (!$isAuthenticationSuccess)
		{
			$showErrorDiv = true;
			if (strlen($username) > 50)
			{
				$username = substr($username, 0, 50);
			}
			Authentication::registerFailedAttempt($username, $password);
		}
		else
		{
			$user = Users::getUser($username);
			$_SESSION["user"] = $user;
			header("location: main.php");
			die();
		}
	}
	else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "registration")
	{
		$firstname = sanitizeInput($_POST["firstname"]);
		$lastname = sanitizeInput($_POST["lastname"]);
		$email = sanitizeInput($_POST["email"]);
		$username = sanitizeInput($_POST["usernameReg"]);
		$password = sanitizeInput($_POST["passwordReg"]);
		$password2 = sanitizeInput($_POST["passwordReg2"]);
		$isDataValid = true;
		
		if (strlen($firstname) > 50)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your first name cannot have more than 50 characters <br />";
		}
		else if ($firstname == "" || strlen($firstname) == 0)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "You must enter your first name <br />";
		}
		
		if (strlen($lastname) > 50)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your last name cannot have more than 50 characters <br />";
		}
		else if ($lastname == "" || strlen($lastname) == 0)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "You must enter your lastn ame <br />";
		}
		
		if (strlen($email) > 75)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your email cannot have more than 75 characters <br />";
		}
		else if ($email == "" || strlen($email) == 0)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "You must enter your email <br />";
		}
		
		if (strlen($username) > 30)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your username cannot have more than 50 characters <br />";
		}
		else if ($username == "" || strlen("username") == 0)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "You must enter your username <br />";
		}
		
		if (strlen($password) < 6)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your password cannot have less than 6 characters <br />";
		}
		else if ($password == "" || strlen($password) == 0)
		{
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "You must enter a password <br />";
		}
		
		if (strcmp($password, $password2) != 0)
		{
			echo $password . " " . $password2;
			$isDataValid = false;
			$showErrorDiv = true;
			$errorMessage = $errorMessage . "Your password does not match <br />";
		}
		
		if ($isDataValid)
		{
			$isRegistrationSuccess = RegisterUser::registerUser($firstname, $lastname, $email, $username, $password);
		
			if (gettype($isRegistrationSuccess) == "string")
			{
				$showErrorDiv = true;
				$errorMessage = "Registration faiiled: " . $isRegistrationSuccess;
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

<!DOCTYPE html">  
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/myStyle.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<title>Login Page</title>
	</head>
	<body>
		<div class="centerWelcome">
			Welcome!
		</div>
		
		<?php
			if ($showErrorDiv)
			{
				echo "<div class='center red'>";
				echo $errorMessage;
				echo "</div>";
			}
		?>
		
		<br />
		<div>
			This is a restricted website. Only authorized people are allowed to access it. <br />
			<br />
			If you have a valid user account, please <a href="#" onclick="showLogin()">log in</a>. <br />
			<br />
			You may also request a user account by filling a <a href="#" onclick="showRegistration()">registration form</a>. <br />
		</div>

		<div id="loginForm" title="Login">
			<div class="center">
				Enter your login information. <br />
			</div>
			<br />
			<form id="login" name="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return checkLogin();">
				<div class="table">
					<div class="fullRow">
						<input id="action" name="action" type="hidden" value="login">
					</div>
					<div class="field">
						Username: 
					</div>
					<div class="input">
						<input id="usernameLog" name="usernameLog" type="text" maxlength="30" />
						<span id="usernameresultlog" name="usernameresultlog"></span><br />
					</div>
					<div class="field">
						Password: 
					</div>
					<div class="input">
						<input id="passwordLog" name="passwordLog" type="password" />
						<span id="passwordresultlog" name="passwordresultlog"></span><br />
					</div>
					<br />
					<br />
					<div class="fieldRow">
						<input type="submit" id="submit" name="submitLogin" value="Submit" />
					</div>
				</div>
			</form>
		</div>
		
		<div id="registrationForm" title="Registration" class="registrationBox">
			<div class="center">
				Fill this registration form. All fields are required. <br />
				An administrator will then review your application.<br /><br />
			</div>
			<form id="registration" name="registration" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return checkRegistration()";>
				<div class="table fontRegistration">
					<div class="fullRow">
						<input id="action" name="action" type="hidden" value="registration">
					</div>
					<div class="field">
						First Name: 
					</div>
					<div class="input">
						<input id="firstname" name="firstname" type="text" maxlength="50" />
						<span id="firstnameresult" name="firstnameresult"></span><br />
					</div>
					<div class="field">
						Last Name: 
					</div>
					<div class="input"">
						<input id="lastname" name="lastname" type="text" maxlength="50" />
						<span id="lastnameresult" name="lastnameresult"></span><br />
					</div>
					<div class="field">
						Email Address: 
					</div>
					<div class="input">
						<input id="email" name="email" type="text" maxlength="75" />
						<span id="emailresult" name="emailresult"></span><br />
					</div>
					<div class="field">
						Username: 
					</div>
					<div class="input">
						<input id="usernameReg" name="usernameReg" type="text" maxlength="30" />
						<span id="usernameresult" name="usernameresult"></span><br />
					</div>
					<div class="field">
						Password: 
					</div>
					<div class="input">
						<input id="passwordReg" name="passwordReg" type="password" maxlength="20" />
						<span id="passwordresult" name="passwordresult"></span><br />
					</div>
					<div class="field">
						Re-enter password: 
					</div>
					<div class="input">
						<input id="passwordReg2" name="passwordReg2" type="password" maxlength="20" />
						<span id="password2result" name="password2result"></span><br />
					</div>
					<div style="fullRow">
						<input type="submit" id="submit" name="submitRegistration" value="Submit" />
					</div>
				</div>
			</form>
		</div>
		
		<script type="text/javascript">
			$(function() {
				$("#email").blur(function() {
					validateEmail();
				});
			
				$("#firstname").blur(function() {
					validateFirstName();
				});
				
				$("#lastname").blur(function() {
					validateLastName();
				});
			
				$("#loginForm").dialog({
					autoOpen: false,
					position: { my: "center center", at: "center top+100" },
					resizable: false,
					width: 500
				});
				
				$("#passwordLog").blur(function() {
					validatePasswordLog();
				});
				
				$("#passwordReg").blur(function() {
					validatePasswordReg();
				});
				
				$("#passwordReg2").blur(function() {
					validatePassword2();
				});
				
				$("#registrationForm").dialog({
					autoOpen: false,
					position: { my: "center center", at: "center top+100" },
					resizable: false,
					width: 750
				});
				
				$("#usernameLog").blur(function() {
					validateUsernameLog();
				});
				
				$("#usernameReg").blur(function() {
					validateUsernameReg();
				});
			});
			
			function checkLogin()
			{
				var isValid = false;
				
				isValid = validateUsernameLog();
				isValid = validatePasswordLog();
				
				return isValid;
			}
			
			function checkRegistration() {
				var isValid = false;
				
				isValid = validateEmail();
				isValid = validateFirstName();
				isValid = validateLastName();
				isValid = validatePasswordReg();
				isValid = validatePassword2();
				isValid = validateUsernameReg();
				
				return isValid;
			}
			
			function showLogin() {
				$("#loginForm").dialog("open");
			}
			
			function showRegistration() {
				$("#registrationForm").dialog("open");
			}
			
			function validateEmail()
			{
				var email = $("#email").val();
				var isValid = false;
				
				if (email == "" || email.length == 0)
				{
					$("#emailresult").html("You must enter your email");
					$("#emailresult").removeClass("red");
					$("#emailresult").removeClass("green");
					$("#emailresult").addClass("red");
					isValid = false;
				}
				else if (email.length > 75)
				{
					$("#emailresult").html("Your email cannot have more than 75 characters");
					$("#emailresult").removeClass("red");
					$("#emailresult").removeClass("green");
					$("#emailresult").addClass("red");
					isValid = false;
				}
				else
				{
					isValid = validateEmail2(email);
				}
				
				return isValid;
			}
			
			function validateEmail2(email)
			{
				$.post("checkemail.php", { email: email }, function(result) 
				{
					var isValid = false;
					if (result == "1")
					{
						$("#emailresult").html("Valid");
						$("#emailresult").removeClass("green");
						$("#emailresult").removeClass("red");
						$("#emailresult").addClass("green");
						isValid = true;
					}
					else
					{
						$("#emailresult").html("Already in use");
						$("#emailresult").removeClass("green");
						$("#emailresult").removeClass("red");
						$("#emailresult").addClass("red");
						isValid = false;
					}
					return isValid;
				});
			}
			
			function validateFirstName()
			{
				var firstname = $("#firstname").val();
				var isValid = false;
					
				if (firstname == "" || firstname.length == 0)
				{
					$("#firstnameresult").html("You must enter your first name");
					$("#firstnameresult").removeClass("red");
					$("#firstnameresult").removeClass("green");
					$("#firstnameresult").addClass("red");
					isValid = false;
				}
				else if (firstname.length > 50)
				{
					$("#firstnameresult").html("Your first name cannot have more than 50 characters");
					$("#firstnameresult").removeClass("red");
					$("#firstnameresult").removeClass("green");
					$("#firstnameresult").addClass("red");
					isValid = false;
				}
				else
				{
					$("#firstnameresult").html("Valid");
					$("#firstnameresult").removeClass("green");
					$("#firstnameresult").removeClass("red");
					$("#firstnameresult").addClass("green");
					isValid = true;
				}
				
				return isValid;
			}
			
			function validateLastName()
			{
				var lastname = $("#lastname").val();
				var isValid = false;
					
				if (lastname == "" || lastname.length == 0)
				{
					$("#lastnameresult").html("You must enter your last name");
					$("#lastnameresult").removeClass("red");
					$("#lastnameresult").removeClass("green");
					$("#lastnameresult").addClass("red");
					isValid = false;
				}
				else if (firstname.length > 50)
				{
					$("#lastnameresult").html("Your last name cannot have more than 50 characters");
					$("#lastnameresult").removeClass("red");
					$("#lastnameresult").removeClass("green");
					$("#lastnameresult").addClass("red");
					isValid = false;
				}
				else
				{
					$("#lastnameresult").html("Valid");
					$("#lastnameresult").removeClass("green");
					$("#lastnameresult").removeClass("red");
					$("#lastnameresult").addClass("green");
					isValid = true;
				}
				
				return isValid;
			}
			
			function validatePassword2()
			{
				var password = $("#passwordReg").val();
				var password2 = $("#passwordReg2").val();
				var isValid = false;
				
				if (password2.length >= 6)
				{
					if (password.localeCompare(password2))
					{
						$("#password2result").html("Password don't match");
						$("#password2result").removeClass("red");
						$("#password2result").removeClass("green");
						$("#password2result").addClass("red");
						isValid = false;
					}
					else
					{
						$("#password2result").html("Valid");
						$("#password2result").removeClass("green");
						$("#password2result").removeClass("red");
						$("#password2result").addClass("green");
						isValid = true;
					}
				}
				else
				{
					$("#password2result").html("&nbsp;");
					$("#password2result").removeClass("green");
					$("#password2result").removeClass("red");
					$("#password2result").addClass("green");
					isValid = false;
				}
				
				return isValid;
			}
			
			function validatePasswordLog()
			{
				var password = $("#passwordLog").val();
				var isValid = false;
				
				if (password == "" || password.length == 0)
				{
					$("#passwordresultlog").html("*");
					$("#passwordresultlog").removeClass("red");
					$("#passwordresultlog").addClass("red");
					isValid = false;
				}
				else
				{
					$("#passwordresultlog").html("&nbsp;");
					$("#passwordresultlog").removeClass("red");
					isValid = true;
				}
				
				return isValid;
			}
			
			function validatePasswordReg()
			{
				var password = $("#passwordReg").val();
				var isValid = false;
					
				if (password == "" || password.length < 6)
				{
					$("#passwordresult").html("Minimum: 6 characters long");
					$("#passwordresult").removeClass("red");
					$("#passwordresult").removeClass("green");
					$("#passwordresult").addClass("red");
					isValid = false;
				}
				else
				{
					$("#passwordresult").html("Valid");
					$("#passwordresult").removeClass("green");
					$("#passwordresult").removeClass("red");
					$("#passwordresult").addClass("green");
					isValid = true;
				}
				
				return isValid;
			}
			
			function validateUsernameLog()
			{
				var username = $("#usernameLog").val();
				var isValid = false;
				
				if (username == "" || username.length == 0)
				{
					$("#usernameresultlog").html("*");
					$("#usernameresultlog").removeClass("red");
					$("#usernameresultlog").addClass("red");
					isValid = false;
				}
				else
				{
					$("#usernameresultlog").html("&nbsp;");
					$("#usernameresultlog").removeClass("red");
					isValid = true;
				}
				
				return isValid;
			}
			
			function validateUsernameReg()
			{
				var username = $("#usernameReg").val();
				var isValid = false;
					
				if (username == "" || username.length == 0)
				{
					$("#usernameresult").html("You must enter your username");
					$("#usernameresult").removeClass("red");
					$("#usernameresult").removeClass("green");
					$("#usernameresult").addClass("red");
					isValid = false;
				}
				else if (username.length > 30)
				{
					$("#usernameresult").html("Your username cannot have more than 30 characters");
					$("#usernameresult").removeClass("red");
					$("#usernameresult").removeClass("green");
					$("#usernameresult").addClass("red");
					isValid = false;
				}
				else
				{
					isValid = validateUsernameReg2(username);
				}
			}
			
			function validateUsernameReg2(username)
			{
				$.post("checkusername.php", { username: username }, function(result) 
				{
					var isValid = false;
					//if the result is 1
					if (result == "1") 
					{
						//show that the username is available
						$("#usernameresult").html("Valid");
						$("#usernameresult").removeClass("green");
						$("#usernameresult").removeClass("red");
						$("#usernameresult").addClass("green");
						isValid = true;
					}
					else
					{
						//show that the username is NOT available
						$("#usernameresult").html("Already in use");
						$("#usernameresult").removeClass("green");
						$("#usernameresult").removeClass("red");
						$("#usernameresult").addClass("red");
						isValid = false;
					}
					
					return isValid;
				});
			}
		</script>
	</body>
</html>