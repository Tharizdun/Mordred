<?php

require_once "Users.php";

class Authorization
{
	function __construct()
	{
		
	}

	function AuthorizeUser($email, $pass)
	{
		$users = new Users();
		
		$userPass = $users->GetUserInfo($email, "Password");
		
		if ($userPass == NULL)
			return false;
		else if ($pass == $userPass['Password'])
			return true;
		else
			return false;
	}
}