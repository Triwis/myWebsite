<?php
	include_once('database.php');
	include_once('user.php');
	include_once('encrypter.php');
	
	class Authentication
	{
		private function __construct() { }
		private static $initialized = false;
		private static $myDB;
		
		private static function initialize()
		{
			if (self::$initialized)
				return;
			self::$myDB = new Database;
		}
		
		public static function registerFailedAttempt($username, $password)
		{
			self::initialize();
			self::$myDB->openDatabase();

			date_default_timezone_set("America/Montreal");
			$now = getdate();
			
			$usernameSafe = self::$myDB->escapeString($username);
			$passwordSafe = self::$myDB->escapeString($password);
			
			$nowString = $now["mon"] . "-" . $now["mday"] . "-" . $now["year"] . " " . $now["hours"] . ":" . $now["minutes"] . ":" . $now["seconds"];
			self::$myDB->insertQuery("failedloging", "username, datetried, passwordtried", "'" . $usernameSafe . "', '" . $nowString . "', '" . $passwordSafe . "'");
			
			self::$myDB->closeDatabase();
		}
		
		public static function authenticateUser($username, $password)
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$validationSuccess = self::validateUsername($username);
			if ($validationSuccess)
			{
				$validationSuccess = self::validatePassword($password, $username);
			}
			
			self::$myDB->closeDatabase();
			return $validationSuccess;
		}
		
		private static function validateUsername($username)
		{
			$username = self::$myDB->escapeString($username);
			$resultQuery = self::$myDB->selectQueryWhere("username", "users", "username = '" . $username . "' AND isactive=1;");
			$isValid = false;
			if ($resultQuery && $resultQuery->num_rows === 1)
			{
				$isValid = true;
				$resultQuery->free();
			}
			return $isValid;
		}
		
		private static function validatePassword($password, $username)
		{
			$username = self::$myDB->escapeString($username);
			$resultQuery = self::$myDB->selectQueryWhere("password", "users", "username = '" . $username . "' AND isactive=1;");
			$encPassword = "";
			while($row = $resultQuery->fetch_assoc())
			{
				$encPassword = $row['password'];
			}
			$resultQuery->free();
			return self::comparePasswords($password, $encPassword);
		}
		
		private static function comparePasswords($receivedPassword, $dbPassword)
		{
			return isPasswordValid($receivedPassword, $dbPassword);
		}
	}
?>