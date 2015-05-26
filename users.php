<?php
	include_once('user.php');
	include_once('database.php');
	
	class Users
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
		
		public static function setNewUser($id, $authLevel, $isActive)
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$x = self::$myDB->updateQuery("users", "isActive = " . $isActive . ", authLevel = " . $authLevel . ", isNew = 0", "id = " . $id);
			
			self::$myDB->closeDatabase();
			return $x;
		}
		
		public static function getUser($username)
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$id;
			$username;
			$authLevel;
			
			$username = self::$myDB->escapeString($username);
			$resultQuery = self::$myDB->selectQueryWhere("id, username, authLevel", "users", "username = '" . $username . "' AND isactive = 1");
			if ($resultQuery->num_rows !== 1)
			{
				return;
			}
			
			while($row = $resultQuery->fetch_assoc())
			{
				$username = $row['username'];
				$authLevel = (int)$row['authLevel'];
				$id = (int)$row['id'];
			}
			$resultQuery->free();
			$user = new User($username, $authLevel, $id);
			
			self::$myDB->closeDatabase();
			return $user;
		}
		
		public static function getAllUsers()
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$resultQuery = self::$myDB->selectQuery("id, username, authlevel", "users");
			
			self::$myDB->closeDatabase();
			return $resultQuery;
		}
		
		public static function getAllNewUsers()
		{
			self::initialize();
			self::$myDB->openDatabase();
			
			$resultQuery = self::$myDB->selectQueryWhere("id, username, firstname, lastname, email", "users", "isnew = 1");
			
			self::$myDB->closeDatabase();
			return $resultQuery;
		}
	}
?>