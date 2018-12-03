<?php

require_once "Common.php";
require_once "Authorization.php";

$auth = new Authorization();
$users = new Users();

$userID = "";
$userInfo = "";
$showAlert = false;
$showSuccess = false;
$message  = "";
$messageAlert  = "";

if (!empty($_POST) && !empty($_GET))
{
	if (isset($_GET['id']))
	{
		if ($_GET['id'] == "-1")
		{
			$userInfo = $users->GetUserInfo($_SESSION['email'], "ID");
			$userID = $userInfo[0];
		}
		else		
		{
			$userInfo = $users->GetUserByID( $_GET['id']);
			$userID = $_GET['id'];
		}
	}
	else
	{
		$userInfo = $users->GetUserInfo($_SESSION['email'], "ID");
		$userID = $userInfo[0];
	}

	if (isset($_GET['form']))
	{
		switch ($_GET['form'])
		{
			case "pass":
				
				$userInfo = $users->GetUserByID($userID);
			
				if ($_POST['Password'] == $_POST['PasswordAgain'])
				{
					if (strlen($_POST['Password']) > 5)
					{
						if ($auth->AuthorizeUser($userInfo['Email'], $_POST['OldPassword'] ))
						{
							$users->UpdateInfo($userID, "Password", $_POST['Password']);
							$showSuccess = true;
							$message = "Your password has been changed";
						}
						else
						{
							$showAlert = true;
							$messageAlert = "Your old password is not correct";
						}
					}
					else
					{
						$showAlert = true;
						$messageAlert = "Your password is too short";
					}
				}
				else
				{
					$showAlert = true;
					$messageAlert = "Your passwords are not same";
				}
				
				break;
			
			case "info":
				$users->UpdateInfo($userID, "FirstName", $_POST['firstName']);
				$users->UpdateInfo($userID, "LastName", $_POST['lastName']);
				$users->UpdateInfo($userID, "Phone", $_POST['phone']);
				$users->UpdateInfo($userID, "Occupation", $_POST['occupation']);
				$users->UpdateInfo($userID, "School", $_POST['school']);
				$users->UpdateInfo($userID, "Birthday", $_POST['bday']);
				$users->UpdateInfo($userID, "RelationshipStatus", $_POST['RelationshipStatus']);
				$users->UpdateInfo($userID, "Email", $_POST['email']);
				$users->UpdateInfo($userID, "Residence", $_POST['residence']);
				
				$userRelation = $users->GetUserInfo($_POST['relationship'], "ID");
				if ($userRelation == NULL)
				{
					$showAlert = true;
					$messageAlert = "Partner error: User with this email is not in system";
				}
				else
					$users->UpdateInfo($userID, "Relationship", $userRelation['ID']);
				
				$userInfo = $users->GetUserByID($userID);
				
				$showSuccess = true;
				$message = "Your data has been changed";
				break;
				
			case "deactivate":
				
				$userInfo = $users->GetUserByID($userID);
			
				if ($_POST['DeactivatePass'] == $_POST['DeactivatePassAgain'])
				{
						if ($auth->AuthorizeUser($_SESSION['email'], $_POST['DeactivatePass'] ))
						{
							$users->DeactivateUser($userID);
							
							$currentUserID = $users->GetUserInfo($_SESSION['email'], "ID");
							
							if ($currentUserID['ID'] == $userID)
								redirect("signout");
							else
							{
								$showSuccess = true;
								$message = "User has been deactivated";
							}
						}
						else
						{
							$showAlert = true;
							$messageAlert = "Your password is not correct";
						}
				}
				else
				{
					$showAlert = true;
					$messageAlert = "Your passwords are not same";
				}
				
				break;
		}
	}
}
else
{
	if (!empty($_GET))
		if (isset($_GET['id']))
		{
			if ($_GET['id'] == "-1")
			{
				$userInfo = $users->GetUserInfo($_SESSION['email']);
				$userID = $userInfo[0];
			}
			else		
			{
				$userInfo = $users->GetUserByID( $_GET['id']);
				$userID = $_GET['id'];
			}
		}
		else
		{
			$userInfo = $users->GetUserInfo($_SESSION['email']);
			$userID = $userInfo['ID'];
		}
	else
	{
		$userInfo = $users->GetUserInfo($_SESSION['email']);
		$userID = $userInfo['ID'];	
	}
}

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

$currentUser = $users->GetUserInfo($_SESSION['email']);
if (!$currentUser['Admin'] && $userID != $currentUser['ID'])
	redirect("settings");

MakeHeader("Settings", "homepage");

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
            <form method="post" class="settings-form-field" accept-charset="utf-8">
             
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
                        <input type="date" class="form-item" name="Date">
                    </div>
                
                    <div class="form">
                        <p>Time</p>
                        <input type="time" class="form-item" name="Time">
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


    </div>
</div>
<?php

	MakeConversationPane();
}