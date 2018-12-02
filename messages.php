<?php

require_once "Common.php";
require_once "Conversations.php";

$userID = "";
$conversationID = "";
$users = new Users();
$currentUserID = $users->GetUserInfo($_SESSION['email'], "ID");
$currentUserID = $currentUserID['ID'];
$convs = new Conversations();

/*require 'TaskRunner.php';
$task = new TaskRunner();
$task->config(array(
		'syncInterval'=>1,
		'taskName'=>'MessageRefresh'
));

$task->run(function(){
	echo "Task Ran";
});*/

if (!empty($_POST)) 
{
    $message = $_POST['message'];
	
	if (!empty($_GET))
	{	
		if (isset($_GET['convID']))
		{	
			$conversationID = $_GET['convID'];		
			
			$userConvs = $convs ->GetAllUserConversations($currentUserID);
			
			$goHome = True;
			
			if (in_array($conversationID, $userConvs))
			{
				$goHome = False;
			}
			
			if ($goHome)
			{
    			redirect('homepage');
			}
		}
	}
	
	$convs->AddMessage($conversationID, $currentUserID, $message);
}

if (!empty($_GET))
{
	if (isset($_GET['userIDs']) && isset($_GET['action']))
	{
		if ($_GET['userIDs'] != "" && $_GET['action'] != "")
		{
			switch ($_GET['action'])
			{
				case 'create':
					
					$userIDs = explode(',', $_GET['userIDs']);
			
					$conversationID =  $convs->GetConversationForUsers($userIDs, $currentUserID);
			
					if ($conversationID == -1)
					{
						$conversationID = $convs->CreateConversation($currentUserID);
						
						foreach($userIDs as $convUser)
							$convs->AddConvUser($convUser, $conversationID);
					}
					
					redirect('messages?convID=' . $conversationID);
					
					break;
			}
		}
	}
	else
	{
		if (isset($_GET['id']))
		{
			$userID = $_GET['id'];
			
			$conversationID =  $convs->GetConversationForUser($userID, $currentUserID);
			
			if ($conversationID == -1)
			{
				$conversationID = $convs->CreateConversation($currentUserID);
				$convs->AddConvUser($userID, $conversationID);
			}		
		}	
		
		if (isset($_GET['convID']))
		{	
			$conversationID = $_GET['convID'];		
			
			$userConvs = $convs ->GetAllUserConversations($currentUserID);
			
			$goHome = True;
			
			if (in_array($conversationID, $userConvs))
			{
				$goHome = False;
			}
			
			if ($goHome)
			{
    			redirect('homepage');
			}
		}	
	}
}

$page = "messages?convID=" . $conversationID;
$sec = "15";
header("Refresh: $sec; url=$page");

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

MakeHeader("Messages", "homepage");

MakeMenu();

?>

<div class="messages">
<<<<<<< HEAD
    <div class="messageWindow">
	
=======
	<div class="messageHeader">
>>>>>>> parent of 0bf2ed9... Profile layout changes
        <?php
		
		$convUsers = $convs->GetUsersForConversations($conversationID);
		
		$header = "";
		
		foreach($convUsers as $user)
		{
			if ($user['IDUser'] == $currentUserID)
				continue;
			
        	$userInfo = $users->GetUserByID($user['IDUser']);
        	$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
			
			$header .= "<a href=\"profile?id=" . $userInfo['ID'] . "\">" . $userName . "</a>, ";
		}
		
		echo "<h2>Chat: " . substr($header, 0, strlen($header) - 2) . "</h2>";
<<<<<<< HEAD

=======
		?>
    </div>
    <div  class="messageWindow">
<?php
>>>>>>> parent of 0bf2ed9... Profile layout changes
        $allMessages = $convs->GetMessages($conversationID);

        if ($allMessages != NULL)
        {					
                foreach ($allMessages as $message)
                {
                        $userInfo = $users->GetUserByID($message['IDSender']);
                        $userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];

                        $owner = $userInfo['Email'] == $_SESSION['email'];

                        echo "<div class=\"post\">";
                        echo "	<p class=\"title\">";
                        echo "		<span class=\"author\"><a href=\"profile?id=" . $message['IDSender'] . "\">" . $userName . "</a></span>";
                        echo "		<span class=\"time\">" . $message['Time'] . "</span>";
                        echo "	</p>";
                        echo "	<div class=\"message\">";
<<<<<<< HEAD
                        echo $message['Message'];
=======
                        echo $convs->GetTag($message['Message']);
>>>>>>> parent of 0bf2ed9... Profile layout changes
                        echo "	</div>";
                        echo "</div>";
                }
        }

        ?>
    </div>
    
    <div class="chatArea">
        <div class="separator">
            <hr>
        </div>
        <form class="messages-post" method="post" action="messages?convID=<?php echo $conversationID; ?>">
                <textarea type="text" class="input-area" name="message" placeholder="Message"></textarea>
                <input type="submit" value="Send" class="post-button">
        </form>
    </div>
</div>

<?php

	MakeConversationPane();
}