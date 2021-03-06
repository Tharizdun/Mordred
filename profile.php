<?php

require_once "Common.php";
require_once "Posts.php";
require_once "Conversations.php";

$id = -1;	
		
$users = new Users();	
$convs = new Conversations();

$isAdmin = $users->GetUserInfo($_SESSION['email'], "ID, Admin");
$currentUserID = $isAdmin['ID'];

if (!empty($_POST)) 
{
	if (isset($_POST['message']))
	{
    	$message = $_POST['message'];
    	$email = $_SESSION['email'];
		
		$posts = new Posts();
		
		$posts->AddPost($email, $message);
		
		unset($_POST['message']);
	}
}

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

	if ($id == -1)
	{
		$user = $users->GetUserInfo($_SESSION['email'], "ID, Email, FirstName, LastName");
		$isOwner = $isOwner || True;
	}
	else
	{
		$user = $users->GetUserByID($id);
		
		if ($user['Email'] == $_SESSION['email'])
			$isOwner = true;
		
		if ($user['Deleted'])
			redirect("homepage");
	}

	MakeHeader($user['FirstName'] . " " .  $user['LastName'], "homepage");

	MakeMenu();

?>
	<main class="profile">
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
			echo "	<a href=\"about?id=" . $id . "\" class=\"btn btn-secondary\">About</a>";
			echo "	<a href=\"friends?id=" . $id . "\" class=\"btn btn-secondary\">Friends</a>";
								
			if ($isOwner || $isAdmin)
			{
  				echo "	<a href=\"settings?id=" . $id . "\" class=\"btn btn-secondary\">Settings</a>";
			}
			
			echo "</div>";
		?>
		
			<hr class="separator2">
			
		<?php	
			echo "<h3 class='separator2'>What are you doing today?</h3>";
			
			if ($isOwner)
			{
                echo "<div class=\"chatArea2\">";
				echo "<form class=\"messages-post\" action=\"profile?id=" . $id . "\" method=\"post\" accept-charset='UTF-8'>";
				echo "		<textarea type=\"text\" class=\"input-area\" name=\"message\" placeholder=\"Post message\"></textarea>";
				echo "		<input type=\"submit\" value=\"Post\" class=\"post-button\">";
				echo "</form>";
				echo "	</div>";
				echo "<hr class='separator2'>";
			}
                        
			echo "	<div class=\"messageWindow\">";
                        
			$posts = new Posts();
				
				$allPosts = $posts->GetPosts($user['Email'], False);
				
				if ($allPosts != NULL)
				{						
					$users = new Users();
					
					$allPosts = array_reverse($allPosts);
					
					$isUserAdmin = $users->GetUserInfo($_SESSION['email'], "Admin");
					$isUserAdmin = $isUserAdmin['Admin'];
						
					for ($i = 0; $i < sizeof($allPosts); $i++)
					{
						$post = $allPosts[$i];
						
						$userInfo = $users->GetUserByID($post['IDUser']);
						$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
						
						$owner = $userInfo['Email'] == $_SESSION['email'];
						
						echo "<div class=\"post\">";
						echo "	<p class=\"title\">";
						echo "		<span class=\"author\">" . $userName . "</a></span>";
						echo "		<span class=\"time\">" . $post['Time'] . "</span>";
						echo "	</p>";
						echo "	<div class=\"message\">";
						echo $convs->GetTag($post['Message']);
						echo "	</div>";
						
						if ($owner || $isUserAdmin)
							echo "<a href=\"homepage?action=delete&id=" . $post['ID'] . "\" type=\"button\" class=\"btn btn-primary manage\">Delete post</a>";
						
						echo "</div>";
					}
				}
                        echo "	</div>";
		
		?>
	</main>
<?php

	MakeConversationPane();
}