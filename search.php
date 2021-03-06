<?php

require_once "Common.php";
require_once "Searching.php";
require_once "Conversations.php";

$id = -1;	
		
$users = new Users();
$search = new Searching();
$convs = new Conversations();

$isAdmin = $users->GetUserInfo($_SESSION['email'], "ID, Admin");
$currentUserID = $isAdmin['ID'];
$searchQuery = "";

if (!empty($_POST))
{
	$searchQuery = $_POST['search'];
}

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

	MakeHeader("Search: " . $searchQuery, "homepage");

	MakeMenu();

?>
	
	<div class="search">
	<h2> Searching: <?php echo $searchQuery; ?></h2>
		<h4>Users</h4>
		
				<?php
				
				$allUsers = $search->GetUsers($searchQuery);
				
				if ($allUsers != NULL)
				{
						
					foreach($allUsers as $user)
					{
						$userName = $user['FirstName'] . " " .  $user['LastName'];
						
						echo "<div class=\"post\">";
						echo "	<p class=\"title\">";
						echo "		<span class=\"author\"><a href=\"profile?id=" . $user['ID'] . "\">" . $userName . "</a></span>";
						echo "	</p>";				
						echo "</div>";
					}
				}
				
				?>
				
		<h4>Posts</h4>	
		
				<?php
				
				$allPosts = $search->GetPosts($searchQuery);
				
				if ($allPosts != NULL)
				{					
					$allPosts = array_reverse($allPosts);
					
					$isUserAdmin = $users->GetUserInfo($_SESSION['email'], "Admin");
					$isUserAdmin = $isUserAdmin['Admin'];
						
					foreach($allPosts as $post)
					{
						$userInfo = $users->GetUserByID($post['IDUser']);
						$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
						
						$owner = $userInfo['Email'] == $_SESSION['email'];
						
						echo "<div class=\"post\">";
						echo "	<p class=\"title\">";
						echo "		<span class=\"author\"><a href=\"profile?id=" . $post['IDUser'] . "\">" . $userName . "</a></span>";
						echo "		<span class=\"time\">" . $post['Time'] . "</span>";
						echo "	</p>";
						echo "	<div class=\"message\">";
						echo $convs->GetTag($post['Message']);
						echo "	</div>";
						
						echo "</div>";
					}
				}
				
				?>
	
	</div>
	
<?php

	MakeConversationPane();
}