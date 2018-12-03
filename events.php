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

if (!empty($_POST))
{
	$title = $_POST['Title'];
	$description = $_POST['Description'];
	$time = $_POST['Time'];
	$date = $_POST['Date'];
	$place = $_POST['Place'];

	$acts->AddEvent($currentUser['ID'], $title, $description, $time, $date, $place);
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
            <form method="post" class="settings-form-field" action="events" accept-charset="utf-8">
             
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
                pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>pepa<br>
            </div>
            
            <div class="addUser">
                <form class="formWrap" method="post" accept-charset="UTF-8">
                    
                    <select class="form-select" name="addedUser">
                        <option value="id1?">Jan Rajnoha</option>
                        <option value="id2?">Martin Zednicek</option>
                        <option value="id3?">Ales Kravic</option>
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