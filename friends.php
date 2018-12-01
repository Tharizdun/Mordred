<?php

require_once "Common.php";
require_once "Users.php";

$id = -1;	
		
$users = new Users();	

$isAdmin = $users->GetUserInfo($_SESSION['email'], "ID, Admin");
$currentUserID = $isAdmin['ID'];

if (!empty($_GET))
{
	$id = $_GET['id'];
	
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
		
		if ($action != NULL && $action != "")
		{	
			switch($action)
			{	
				case 'remove':
					$users->SwitchFriend($id, $currentUserID, false);
					break;
					
				case 'add':			
					$users->SwitchFriend($id, $currentUserID);
					break;
			}	
		}	
	}
}

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{
	$user = "";
	
	$isAdmin = $isAdmin['Admin'];
	$isOwner = False;

	if ($id == -1)
	{
		$user = $users->GetUserInfo($_SESSION['email'], "ID, FirstName, LastName");
		$isOwner = $isOwner || True;
	}
	else
	{
		$user = $users->GetUserByID($id);
		
		if ($user['Email'] == $_SESSION['email'])
			$isOwner = true;
	}

	MakeHeader($user['FirstName'] . " " .  $user['LastName'], "homepage");

	MakeMenu();

?>
	<div class="user">
		<h1 class="name"><?php echo $user['FirstName'] . " " .  $user['LastName']; ?></h1>
		
		<?php 		
			
			echo "<div class=\"btn-group\" role=\"group\" aria-label=\"Manage user\">";
			
			if (!$isOwner)
			{
				$allFriends = $users->GetFriends($currentUserID);
				
				if (in_array($id, $allFriends))
					echo "	<a class=\"btn btn-secondary\" href=\"profile.php?action=remove&id=" . $id . "\">Remove friend</a>";
				else
					echo "	<a class=\"btn btn-secondary\" href=\"profile.php?action=add&id=" . $id . "\">Add friend</a>";
			}
			
			echo "	<a href=\"profile.php?id=" . $id . "\" class=\"btn btn-secondary\">Feed</a>";
			echo "	<a href=\"friends.php?id=" . $id . "\" class=\"btn btn-secondary\">Friends</a>";
  			echo "	<a href=\"photos.php?id=" . $id . "\" class=\"btn btn-secondary\">Photos</a>";
								
			if ($isOwner || $isAdmin)
			{
  				echo "	<button type=\"button\" class=\"btn btn-secondary\">Settings</button>";
			}
			
			echo "</div>";
			echo "<hr>";
			
			
			
			?>
	</div>
<?php
}