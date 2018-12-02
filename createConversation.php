<?php

require_once "Common.php";
require_once "Users.php";

$id = -1;	
		
$users = new Users();

$isAdmin = $users->GetUserInfo($_SESSION['email'], "ID, Admin");
$currentUserID = $isAdmin['ID'];
$conversationID = "";
$selectedUsers = "";

if (!empty($_GET))
{
	if (isset($_GET['userIDs']))
		$selectedUsers = $_GET['userIDs'];
}

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

	MakeHeader("Creating new conversation", "homepage");

	MakeMenu();

?>
	
	<div class="search">
		<h2> Select users for conversations</h2>
		
				<?php
				
				$userIDs = explode(',', $selectedUsers);
				
				$allUsers = $users->GetAllUsers();
				
				if ($allUsers != NULL)
				{						
					foreach($allUsers as $user)
					{
						if ($user['Email'] != $_SESSION['email'] && !in_array($user['ID'], $userIDs))
						{
							$userName = $user['FirstName'] . " " .  $user['LastName'];
							
							echo "<div class=\"post\">";
							echo "	<p class=\"title\">";
							echo "		<span class=\"author\"><a href=\"createConversation?userIDs=" . $selectedUsers . ($selectedUsers == "" ? "" : ",") . $user['ID'] . "\">" . $userName . "</a></span>";
							echo "	</p>";				
							echo "</div>";
						}
					}
				}
				
				if ($selectedUsers != "")
					echo "<a href=\"messages?action=create&userIDs=" . $selectedUsers . "\" type=\"button\" class=\"btn btn-primary manage\">Finish</a>";
				
				?>	
	</div>
	
<?php

	MakeConversationPane();
}