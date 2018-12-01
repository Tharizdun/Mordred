<?php

require_once "DBConnection.php";

class Users
{

	private $dbc;
	
	function __construct()
	{
			$this->dbc = new DBConnect();
	}
	
	function GetUserInfo($email, $column = "*")
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
	
	function RegisterUser($firstName, $lastName, $email, $pass)
	{
		$query = "INSERT INTO `xzedni12`.`Users` (`ID`, `School`, `Residence`, `Occupation`, `Phone`, `RelationshipStatus`, `Relationship`, `Deleted`, `Email`, `Password`, `Admin`, `FirstName`, `LastName`) VALUES (NULL, '', '', '', '', '', '', '0', '" . $email . "', '" . $pass . "', '0', '" . $firstName . "', '" . $lastName . "');";
			
		$this->dbc->DoQuery($query);
	}
	
	function GetFriends($id)
	{
		try
		{
			$allFriends = array();
		
			$userFriends1 = $this->dbc->Select("Friends", "IDUser2", "IDUser1='" . $id . "'")->FetchAll();
			$userFriends2 = $this->dbc->Select("Friends", "IDUser1", "IDUser2='" . $id . "'")->FetchAll();
			
			if ($userFriends2 != NULL)
			{
				foreach ($userFriends2 as $friend)
				{
					array_push($allFriends, $friend[0]);
				}
			}
			
			if ($userFriends1 != NULL)
			{
				foreach ($userFriends1 as $friend)
				{
					array_push($allFriends, $friend[0]);
				}
			}
				
			return $allFriends;
			
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: Users.php: " . $e . " );</script>";
		}
	}
	
	function SwitchFriend($id, $owner, $addFriend = true)
	{	
		if ($addFriend)
		{			
			$query = "INSERT INTO `xzedni12`.`Friends` (`ID` ,`IDUser1` ,`IDUser2` ) VALUES (NULL , '" . $id . "', '" . $owner . "');";			
			$this->dbc->DoQuery($query);
		}
		else
		{			
			$this->dbc->Delete("Friends", "(IDUser1='" . $id . "' AND IDUser2='" . $owner . "') OR (IDUser1='" . $owner . "' AND IDUser2='" . $id . "')");
		}
	}
}




