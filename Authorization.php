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
		
		$user = $dbc->GetUser($email);
		
		if ($user == NULL)
			return false;
		else if ($pass == $user)
			return true;
		else
			return false;
	}
}