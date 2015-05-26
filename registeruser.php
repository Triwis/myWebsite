<?php
	include_once('encrypter.php');
	include_once('database.php');
	
	class RegisterUser
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
		
		public static function registerUser($firstname, $lastname, $email, $username, $password)
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$returnValue = "";
			
			$isUsernameTaken = self::doesUsernameExists($username);
			$isEmailTaken = self::doesEmailExists($email);
			if (!$isUsernameTaken && !$isEmailTaken)
			{
				$encPassword = encryptPassword($password);
				self::insert($firstname, $lastname, $email, $username, $encPassword);
				$returnValue = true;
			}
			else if ($isUsernameTaken) 
			{
				$returnValue = "This username is already taken";
			}
			else if ($isEmailTaken)
			{
				$returnValue = "This email is already in use";
			}
			
			self::$myDB->closeDatabase();
			return $returnValue;
		}
		
		private static function doesUsernameExists($username)
		{
			$resultQuery = self::$myDB->selectQueryWhere("username", "users", "username = '" . $username . "';");
			$exists = false;
			if ($resultQuery->num_rows === 1)
			{
				$exists = true;
			}
			$resultQuery->free();
			return $exists;
		}
		
		private static function doesEmailExists($email)
		{
			$resultQuery = self::$myDB->selectQueryWhere("email", "users", "email = '" . $email . "';");
			$exists = false;
			if ($resultQuery->num_rows === 1)
			{
				$exists = true;
			}
			$resultQuery->free();
			return $exists;
		}
		
		private static function insert($firstname, $lastname, $email, $username, $password)
		{
			$table = "users";
			$columns = "firstname, lastname, email, username, password, authlevel, isactive";
			$values = "'" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $username . "', '" . $password . "', " . 0 . ", " . 0;
			$resultQuery = self::$myDB->insertQuery($table, $columns, $values);
		}
	}
?>