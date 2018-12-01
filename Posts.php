<?php

require "DBConnection.php";

class Posts
{
	function __construct()
	{
		
	}

	function AddPost($email, $message)
	{
		$dbc = new DBConnect();
		
		$userID = $dbc->GetUserInfo($email, "ID");
		
		if ($userID == NULL)
			return false;
		else 
		{
			$query = "INSERT INTO `xzedni12`.`Posts` (`ID`, `IDUser`, `Message`, `Time`, `Date`, `Shared`, `Deleted`) VALUES (NULL, '" . $userID . "', '" . $message . "', CURRENT_TIMESTAMP, '" . date("Y-m-d") . "', '1', '0');";
			$dbc->DoQuery($query);
		}
	}
}