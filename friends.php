<?php

require_once "Common.php";
require_once "Users.php";

$id = "-1";	
		
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
    redirect('index');
}
else
{
	$user = "";
	
	$isAdmin = $isAdmin['Admin'];
	$isOwner = False;

	if ($id == "-1")
	{
		$user = $users->GetUserInfo($_SESSION['email'], "ID, FirstName, LastName");
		$isOwner = $isOwner || True;
		$id = $user['ID'];
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
	<div class="profile">
		<h1 class="name separator2"><?php echo $user['FirstName'] . " " .  $user['LastName']; ?></h1>
		
		<?php 		
			
			echo "<div class=\"btn-group\" role=\"group\" aria-label=\"Manage user\">";
			
			if (!$isOwner)
			{
				$allFriends = $users->GetFriends($currentUserID);
				
				if (in_array($id, $allFriends))
					echo "	<a class=\"btn btn-secondary\" href=\"profile?action=remove&id=" . $id . "\">Remove friend</a>";
				else
					echo "	<a class=\"btn btn-secondary\" href=\"profile?action=add&id=" . $id . "\">Add friend</a>";
										
				echo "	<a href=\"messages?id=" . $id . "\" class=\"btn btn-secondary\">Message</a>";
			}
			
			echo "	<a href=\"profile?id=" . $id . "\" class=\"btn btn-secondary\">Feed</a>";
			echo "	<a href=\"friends?id=" . $id . "\" class=\"btn btn-secondary\">Friends</a>";
								
			if ($isOwner || $isAdmin)
			{
  				echo "	<a href=\"settings?id=" . $id . "\" class=\"btn btn-secondary\">Settings</a>";
			}
			
			echo "</div>";
			echo "<hr class='separator2'>";
			echo "<div class='messageWindowBig'>";
                        
				$allUsers = $users->GetFriends($id);
				
				if ($allUsers != NULL)
				{						
					foreach($allUsers as $user)
					{
						$userInfo = $users->GetUserByID($user);
						$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
						
                                                echo "<div class=\"friendFrame\">";
						
						echo "<a href=\"profile?id=" . $userInfo['ID'] . "\">" . $userName . "</a>";
										
                                                echo "</div>";
                             
					}
				}
                        echo "</div>";
				
				?>
	</div>
<?php

	MakeConversationPane();
}