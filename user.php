<?php
	class User
	{
		private $username;
		private $authLevel;
		private $id;

		public function __construct($name, $level, $identificationNumber)
		{
			$this->username = $name;
			$this->authLevel = $level;
			$this->id = $identificationNumber;
		}
		
		function getAuthLevel()
		{
			return $this->authLevel;
		}
	}
?>