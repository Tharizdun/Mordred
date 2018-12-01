<?php

require_once "Common.php";
require_once "Posts.php";

$id = -1;	
		
$users = new Users();	

$isAdmin = $users->GetUserInfo($_SESSION['email'], "ID, Admin");
$currentUserID = $isAdmin['ID'];

if (!empty($_POST)) 
{
    $message = $_POST['message'];
    $email = $_SESSION['email'];
	
	$posts = new Posts();
	
	$posts->AddPost($email, $message);
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
    redirect('index.php');
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
	}

	MakeHeader($user['FirstName'] . " " .  $user['LastName'], "homepage");

	MakeMenu();

?>
	<main class="user">
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
										
				echo "	<a href=\"messages.php?id=" . $id . "\" class=\"btn btn-secondary\">Message</a>";
			}
			
			echo "	<a href=\"profile.php?id=" . $id . "\" class=\"btn btn-secondary\">Feed</a>";
			echo "	<a href=\"friends.php?id=" . $id . "\" class=\"btn btn-secondary\">Friends</a>";
  			echo "	<a href=\"photos.php?id=" . $id . "\" class=\"btn btn-secondary\">Photos</a>";
								
			if ($isOwner || $isAdmin)
			{
  				echo "	<button type=\"button\" class=\"btn btn-secondary\">Settings</button>";
			}
			
			echo "</div>";
		?>
		
			<hr>
			
		<?php	
			echo "<h3>What are you doing today?</h3>";
			
			if ($isOwner)
			{
				echo "<form class=\"homepage-post\" action=\"profile.php?id=" . $id . "\" method=\"post\">";
				echo "	<div class=\"post-part\">";
				echo "		<textarea type=\"text\" class=\"post-item\" name=\"message\" placeholder=\"Post message\"></textarea>";
				echo "	</div>";
				echo "	<div class=\"post-part\">";
				echo "		<input type=\"submit\" value=\"Post\" class=\"post-button\">";
				echo "	</div>";
				echo "</form>";
				
				echo "<hr>";
			}
				
			$posts = new Posts();
				
				$allPosts = $posts->GetPosts($user['Email'], False)->fetchAll();
				
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
						echo $post['Message'];
						echo "	</div>";
						
						if ($owner || $isUserAdmin)
							echo "<a href=\"homepage.php?action=delete&id=" . $post['ID'] . "\" type=\"button\" class=\"btn btn-primary manage\">Delete post</a>";
						
						echo "</div>";
					}
				}
		
		?>
	</main>
<?php

	MakeConversationPane();
}