<?php

require_once "Users.php";

class Posts
{
	private $dbc;
	private $users;

	function __construct()
	{
		$this->dbc = new DBConnect();
		$this->users = new Users();
	}

	function AddPost($email, $message)
	{
		$userID = $this->users->GetUserInfo($email, "ID");
		
		if ($userID == NULL)
			return false;
		else 
		{
			$query = "INSERT INTO `xzedni12`.`Posts` (`ID`, `IDUser`, `Message`, `Time`, `Date`, `Shared`, `Deleted`) VALUES (NULL, '" . $userID['ID'] . "', '" . $message . "', CURRENT_TIMESTAMP, '" . date("Y-m-d") . "', '1', '0');";
			
			$this->dbc->DoQuery($query);
		}
	}
	
	function GetPosts($email, $includeFriends = true)
	{
		$userID = $this->users->GetUserInfo($email, "ID");
		
		$friendPosts = "";
		
		if ($includeFriends)
		{
			$friendList = $this->users->GetFriends($userID['ID']);
			
			foreach ($friendList as $friend)
			{
				$friendPosts .= "OR IDUser = '" . $friend . "'";
			}
		}
		
		$allPosts = $this->dbc->Select("Posts", "*", "Deleted <> 1 AND (IDUser = '" . $userID['ID'] . "'" . $friendPosts . ")");
		
		return $allPosts;
	}
	
	function DeletePost($id)
	{
		$this->dbc->Update("Posts", "Deleted", "1", "ID = " . $id);
	}
}