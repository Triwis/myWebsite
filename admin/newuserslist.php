<?php
	include_once('../user.php');
	include_once('../users.php');
	session_start();
	
	$user = $_SESSION["user"];
	if ($user == NULL || $user->getAuthLevel() !== 1)
	{
		session_unset();
		header("location: ../login.php");
		die();
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../css/myStyle.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<title>List of new users</title>
	</head>
	<body>
		<div class="centerWelcome">
			List of newly registered users that have not been approuved.
		</div>
		
		<br />
		<br />
		<div class="margin-down table">
			<div class="center header rowID">
				ID
			</div>
			<div class="center header row">
				Username
			</div>
			<div class="center header row">
				First Name
			</div>
			<div class="center header row">
				Last Name
			</div>
			<div class="center header row">
				Email Address
			</div>
			
			<div class="center header rowAction lastborder">
				Actions
			</div>
		
			<?php
				$listNewUsers = Users::getAllNewUsers();
				while($row = $listNewUsers->fetch_assoc())
				{
					echo "<div class='cell rowID'>";
					echo $row["id"];
					echo "</div>";
					
					echo "<div class='cell row'>";
					echo $row["username"];
					echo "</div>";
					
					echo "<div class='cell row'>";
					echo $row["firstname"];
					echo "</div>";
					
					echo "<div class='cell row'>";
					echo $row["lastname"];
					echo "</div>";
					
					echo "<div class='cell row'>";
					echo $row["email"];
					echo "</div>";
					
					echo "<div class='cell center rowAction lastborder'>";
					echo "<img src='/images/green.png' onclick='showSetAuthLevel(" . $row["id"] . ")'>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<img src='/images/red.png' onclick='refuse(" . $row["id"] . ")'>";
					echo "</div>";
				}
			?>
		</div>
		
		<a href="masterpage.php">Back</a>
		<br />
		<a href="../logout.php">Logout</a>
		
		<div id="setAuthNumer" title="Authorization Level">
			<input type="hidden" id="idAgree" name="idAgree" value="x" />
			Enter the authorization level for this new user:
			<br />
			<input id="authLevel" type="text" size="5" maxLength="2" min="1" max="99" required="true" />
			<br /><br />
			<input id="submit" type="button" value="Submit"/>
		</div>
		
		<script type="text/javascript">
			$(function() {
				$("#setAuthNumer").dialog({
					autoOpen: false,
					resizable: false,
					width: 500
				});
				
				$("#submit").click(function() {
					var id = $("#idAgree").val();
					var authLevel = $("#authLevel").val();
					callScript(id, authLevel, 0);
				});
			});
			
			function callScript(id, authLevel, isActive) 
			{
				$.post('accept.php', {id: id, authLevel: authLevel, isActive: isActive}, function(result) {
					location.reload();
				});
			}
			
			function refuse(id)
			{
				callScript(id, 0, 1);
			}
			
			function showSetAuthLevel(id)
			{
				$("#setAuthNumer").dialog("open");
				$("#idAgree").val(id);
			}
		</script>
	</body>
</html>