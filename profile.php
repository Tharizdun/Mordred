<?php

require_once "Common.php";
require_once "Users.php";

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

	$users = new Users();
	$userName = $users->GetUserInfo($_SESSION['email'], "FirstName, LastName");

	MakeHeader($userName['FirstName'] . " " .  $userName['LastName'], "homepage");

	MakeMenu();

?>
			
			

<?php
}