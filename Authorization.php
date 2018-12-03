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
		
		$userInfo = $users->GetUserInfo($email);
		
		if ($userInfo['Deleted'])
			return false;
		
		if ($userInfo == NULL)
			return false;
		else if ($pass == $userInfo['Password'])
			return true;
		else
			return false;
	}
}