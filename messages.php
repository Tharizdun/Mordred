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

$convName = "";

if (!empty($_POST)) 
{
    $message = $_POST['message'];
	
	if (isset($_POST['topic']))
		$convName = $_POST['topic'];
	
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
						$conversationID = $convs->CreateConversation($currentUserID, $convName);
						
						foreach($userIDs as $convUser)
							$convs->AddConvUser($convUser, $conversationID);
					}
					
					$convs->UpdateConversation($conversationID, $convName);
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
	<div class="messageHeader">
        <?php
		
		$header = "";
		
		$topic = $convs->GetConversationTopic($conversationID);	
		$convUsers = $convs->GetUsersForConversations($conversationID);
		
		if ($topic == "")
		{
			foreach($convUsers as $user)
			{
				if ($user == $currentUserID)
					continue;
				
	        	$userInfo = $users->GetUserByID($user);
				
				if ($userInfo['Deleted'])
					continue;
				
	        	$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
				
				$header .= "<a href=\"profile?id=" . $userInfo['ID'] . "\">" . $userName . "</a>, ";
			}
			
			echo "<h2>Chat: " . substr($header, 0, strlen($header) - 2) . "</h2>";
		}
		else
		{
			$header = $topic;
			echo "<h2>Chat: " . $header . "</h2>";
		}
		
		?>
    </div>
    <div  class="messageWindow">
<?php
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
                        echo $convs->GetTag($message['Message']);
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
        <form class="messages-post" method="post" action="messages?convID=<?php echo $conversationID; ?> " accept-charset="UTF-8">
                <textarea type="text" class="input-area" name="message" placeholder="Message"></textarea>
                <input type="submit" value="Send" class="post-button">
        </form>
    </div>
</div>

<?php

	MakeConversationPane();
}