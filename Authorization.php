<?php

require "DBConnection.php";

class Authorization
{
	function __construct()
	{
		
	}

	function AuthorizeUser($email, $pass)
	{
		$dbc = new DBConnect();
		
		$userPass = $dbc->GetUser($email);
		
		if ($userPass == NULL)
			return false;
		else if ($pass == $userPass)
			return true;
		else
			return false;
	}
}