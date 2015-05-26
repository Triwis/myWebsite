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

<!DOCTYPE html"> 
<html>
	<head>
		<title>View and Modify Users</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body>
		<div>
			<div >
				ID
			</div>
			<div>
				Username
			</div>
			<div>
				Authorization Level
			</div>
			<div>
				Update
			</div>
			<div>
				Delete
			</div>
		</div>
		<?php
			$list = Users::getAllUsers();
			while($row = $list->fetch_assoc()) 
			{
				echo '<div style="">';
				echo $row["id"];
				echo '</div>';
				echo '<div>';
				echo $row["username"];
				echo '</div>';
				echo '<div>';
				echo $row["authlevel"];
				echo '</div>';
				echo '<div>';
				echo 'Update';
				echo '</div>';
				echo '<div>';
				echo 'Delete';
				echo '</div>';
				//echo $row["id"] . " " . $row["username"] . " " . $row["authlevel"];
				
			}
		?>
	</body>
</html>