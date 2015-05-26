<?php
	function encryptPassword($password)
	{
		$encrypt = password_hash($password, PASSWORD_DEFAULT);
		return $encrypt;
	}
	
	function isPasswordValid($enteredPassword, $encPassword) 
	{
		return password_verify($enteredPassword, $encPassword);
	}
?>