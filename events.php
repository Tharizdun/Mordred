<?php

require_once "Common.php";
require_once "Actions.php";

$acts = new Actions();
$users = new Users();

$userID = "";
$userInfo = "";
$showAlert = false;
$showSuccess = false;
$message  = "";
$messageAlert  = "";
$currentUser = $users->GetUserInfo($_SESSION['email']);

if (!empty($_POST) && !empty($_GET))
{
	switch ($_GET['action'])
	{
		case "newEvent":
			$title = $_POST['Title'];
			$description = $_POST['Description'];
			$time = $_POST['Time'];
			$date = $_POST['Date'];
			$place = $_POST['Place'];
		
			$acts->AddEvent($currentUser['ID'], $title, $description, $time, $date, $place);
			break;
			
		case "addUser":
			$acts->AddEventUser($_GET['event'], $_POST['addedUser']);
			break;
	}
}
else
{
	if ( !empty($_GET))
	{
		switch ($_GET['action'])
		{				
			case "remove":
				$acts->RemoveEvent($_GET['id']);
				break;
		}
	}
}

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

MakeHeader("Events", "homepage");

MakeMenu();

?>

<div class="temp-fix">

<?php 
if ($showAlert)
{
	echo "<div class=\"alert alert-danger alert-message\" role=\"alert\">";
  	echo $messageAlert;
	echo "</div>";
}

if ($showSuccess)
{
	echo "<div class=\"alert alert-success alert-message\" role=\"alert\">";
  	echo $message;
	echo "</div>";
}
?>

    <div class="eventsHeader">
  <!-- Trigger the modal with a button -->
  <h1>Events</h1>
<button type="button" class="btn btn-info btn-lg floatRight" data-toggle="modal" data-target="#myModal">New Event</button>
    </div>
    
    
    
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" class="settings-form-field" action="events?action=newEvent" accept-charset="utf-8">
             
                    <div class="form">
                        <p>Title</p>
                        <input type="text" class="form-item" name="Title">
                    </div>
                
                    <div class="form">
                            <p>Place</p>
                            <input type="text" class="form-item" name="Place">
                    </div>
                
                    <div class="form">
                        <p>Date</p>
                        <input type="date" class="form-item" name="Date" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                
                    <div class="form">
                        <p>Time</p>
                        <input type="time" class="form-item" name="Time"  value="<?php echo date("H:i"); ?>">
                    </div>

                    <div class="form">
                            <p>Description</p>
                            <textarea type="text" class="input-area" name="Description" placeholder="Event description"></textarea>
                    </div>
                
                    <div class="form">
                            <input type="submit" class="form-button" value="Create Event">
                    </div>
            </form>
        </div>

      </div>
    </div>


    <div class="eventsWindow borderTop">
        
		<?php 
		
		$events = $acts->GetEvents($currentUser['ID']);
		
		foreach ($events as $event)
		{
			if (strtotime($event['Date']) < strtotime("today"))
				continue;
				
			if (strtotime($event['Time']) < time())
				continue;
			
			$userAttended = $acts->GetEventPeople($event['ID']);
			
		?>
		
        <div class="eventFrame">
            <div class="title">
                <span><?php echo $event['Title']; ?></span>
            </div>
            
            <div class="date">
                <span><?php echo $event['Date']; ?></span>
            </div>
            
            <div class="time">
                <span><?php echo $event['Time']; ?></span>
           	 	<div class="delete">
           		     <a href="events?action=remove&id=<?php echo $event['ID']; ?>">Delete event</a>
           	 	</div>
            </div>            
            
            <div class="PlaceTitle">
                <span>Place</span>
            </div>
            
            <div class="Place">
                <p><?php echo $event['Place']; ?></p>
            </div>
            
            <div class="DescriptionTitle">
                <span>Description</span>
            </div>
            
            <div class="description">
                <p><?php echo $event['Description']; ?></p>
            </div>
            
            
            
            <div class="DescriptionAttendees">
                <span>Attendees</span> 
            </div>
            
            <div class="atttendees">
			<?php
			
				foreach ($userAttended as $user)
				{
					$userInfo = $users->GetUserByID($user);
				
					echo "<a href=\"profile?id=" . $userInfo['ID'] . "\">" . $userInfo['FirstName'] . " " . $userInfo['LastName'] . "</a><br>";
				}
			
			?>
            </div>
            
            <div class="addUser">
                <form class="formWrap" method="post" action="events?action=addUser&event=<?php echo $event['ID']; ?>" accept-charset="UTF-8">
                    
                    <select class="form-select" name="addedUser">
					
					<?php 
					
						$friends = $users->GetFriends($currentUser['ID']);
						
						if ($friends != NULL)
						{						
							foreach($friends as $user)
							{
								if (!in_array($user, $userAttended))
								{
									$user = $users->GetUserByID($user);
								
									$userName = $user['FirstName'] . " " .  $user['LastName'];
									
									echo "<option value=\"" . $user['ID'] . "\">" . $userName . "</option>";
								}
							}
						}					
					?>
					
                    </select>
                    
                    <input type="submit" class="form-add" value="Add">

                </form>
            </div>
        </div>
	
	<?php 
	}
            
	
	?>
        
        

    </div>
</div>
<?php

	MakeConversationPane();
}