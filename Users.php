<?php

require_once "DBConnection.php";

class Users
{

	private $dbc;
	
	function __construct()
	{
			$this->dbc = new DBConnect();
	}
	
	function GetUserInfo($email, $column)
	{
		try
		{		
			$user = $this->dbc->Select("Users", $column, "Email='" . $email . "'");
			
			if (sizeof($user) == 1)
			{
				return $user->fetch();
			}
			else
				return null;	
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: Users.php: " . $e . " );</script>";
		}
	}
	
	function GetUserByID($userID)
	{
		try
		{			
			$user = $this->dbc->Select("Users", "*", "ID='" . $userID . "'");
			
			if (sizeof($user) == 1)
				return $user->fetch();
			else
				return null;	
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: Users.php: " . $e . " );</script>";
		}
	}
}