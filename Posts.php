<?php

require_once "Users.php";

class Posts
{
	function __construct()
	{
		
	}

	function AddPost($email, $message)
	{
		$dbc = new DBConnect();
		$users = new Users();
		
		$userID = $users->GetUserInfo($email, "ID");
		
		if ($userID == NULL)
			return false;
		else 
		{
			$query = "INSERT INTO `xzedni12`.`Posts` (`ID`, `IDUser`, `Message`, `Time`, `Date`, `Shared`, `Deleted`) VALUES (NULL, '" . $userID['ID'] . "', '" . $message . "', CURRENT_TIMESTAMP, '" . date("Y-m-d") . "', '1', '0');";
			
			$dbc->DoQuery($query);
		}
	}
	
	function GetPosts($email)
	{
		$dbc = new DBConnect();
		
		$allPosts = $dbc->Select("Posts");
		
		return $allPosts;
	}
}