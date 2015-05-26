<?php
	class Database 
	{
		private $server = "localhost";
		private $dbuser = "root";
		private $dbpassword = "";
		private $database = "websitedb";
		private $dbconnection;
		
		public function openDatabase()
		{
			$this->dbconnection = new mysqli($this->server, $this->dbuser, $this->dbpassword, $this->database);
			if ($this->dbconnection->connect_error) 
			{
				die("Connection failed: " . $this->dbconnection->connect_error);
			}
		}
		
		public function closeDatabase()
		{
			$this->dbconnection->close();
		}
		
		public function selectQuery($columns, $table)
		{
			$query = "SELECT " . $columns . " FROM " . $table . ";";
			$result = $this->dbconnection->query($query);
			return $result;
		}
		
		public function selectQueryOrderby($columns, $table, $orderby)
		{
			$query = "SELECT " . $columns . " FROM " . $table . " ORDER BY " . $orderby . ";";
			$result = $this->dbconnection->query($query);
			return $result;
		}
		
		public function selectQueryWhere($columns, $table, $where)
		{
			$query = "SELECT " . $columns . " FROM " . $table . " WHERE " . $where . ";";
			//echo $query;
			$result = $this->dbconnection->query($query);
			return $result;
		}
		
		public function insertQuery($table, $columns, $values)
		{
			$query = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ");";
			//echo $query;
			$this->dbconnection->query($query);
			$this->dbconnection->commit();
		}
		
		public function updateQuery($table, $setStatement, $where)
		{
			$query = "UPDATE " . $table . " SET " . $setStatement . " WHERE " . $where . ";";
			//echo $query;
			$this->dbconnection->query($query);
			$this->dbconnection->commit();
			return $query;
		}
		
		public function deleteQuery($table, $whereStatement)
		{
			$query = "DELETE FROM " . $table . " WHERE " . $whereStatement;
			//echo $query;
			$this->dbconnection->query($query);
		}
		
		/*
		======================================================
						Utility functions
		======================================================
		*/
		public function escapeString($string)
		{
			return $this->dbconnection->real_escape_string($string);
		}
		
		/*
		//PLEASE FOLLOW THE SAME PATTERN FOR CREATNNG NEW USERS
		public function createUserTriwis()
		{
			$username = "Triwis";
			$password = "Template";
			$authlevel = 1;
			$encpassword = encryptPassword($password);
			
			$query = "INSERT INTO users (username, password, authlevel) VALUES ('" . $username . "', '" . $encpassword . "', " . $authlevel . ");";
			$this->dbconnection->query($query);
		}
		*/
	}
?>