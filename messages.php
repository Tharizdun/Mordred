<?php

require_once "Common.php";
require_once "Conversations.php";

$userID = "";
$conversationID = "";
$users = new Users();
$currentUserID = $users->GetUserInfo($_SESSION['email'], "ID");
$currentUserID = $currentUserID['ID'];
$convs = new Conversations();

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

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

MakeHeader("Messages", "homepage");

MakeMenu();

?>

<div class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content messages">
    <div class="messageWindow">
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
                        echo $message['Message'];
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