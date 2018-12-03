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

    <form method="post" class="settings-form-field" action="settings?id=<?php echo $userID; ?>&form=info" accept-charset="utf-8">
        <div class="settings-form-subsection">
            <div class="form">
                    <p>First name</p>
                    <input type="text" class="form-item" name="firstName" value="<?php echo $userInfo['FirstName']; ?>">
            </div>

            <div class="form">
                    <p>Last name</p>
                    <input type="text" class="form-item" name="lastName" value="<?php echo $userInfo['LastName']; ?>">
            </div>

            <div class="form">
                    <p>Email</p>
                    <input type="email" class="form-item" name="email" value="<?php echo $userInfo['Email']; ?>">
            </div>

            <div class="form">
                    <p>Phone</p>
                    <input type="tel" class="form-item" name="phone" value="<?php echo $userInfo['Phone']; ?>">
            </div>
			
            <div class="form">
                <p>Relationship Status</p>
                <select class="form-item" name="RelationshipStatus">
                    <option value="single" <?php echo $userInfo['RelationshipStatus'] == "single" ? "selected" : ""; ?>> Single</option>
                    <option value="dating" <?php echo $userInfo['RelationshipStatus'] == "dating" ? "selected" : ""; ?>> Dating</option>
                    <option value="married" <?php echo $userInfo['RelationshipStatus'] == "married" ? "selected" : ""; ?>> Married</option>
                    <option value="complicated" <?php echo $userInfo['RelationshipStatus'] == "complicated" ? "selected" : ""; ?>> Complicated</option>
                    <option value="widowed" <?php echo $userInfo['RelationshipStatus'] == "widowed" ? "selected" : ""; ?>> Widowed</option>
                </select>
            </div>
            
            <div class="form spacing">
    	            <input type="submit" class="form-button" value="Save Settings">
            </div>
        </div>
        
        <div class="settings-form-subsection">
            <div class="form">
                    <p>Residence</p>
                    <input type="text" class="form-item" name="residence" value="<?php echo $userInfo['Residence']; ?>">
            </div>
			
            <div class="form">
                    <p>School</p>
                    <input type="text" class="form-item" name="school" value="<?php echo $userInfo['School']; ?>">
            </div>

            <div class="form">
                    <p>Work</p>
                    <input type="text" class="form-item" name="occupation" value="<?php echo $userInfo['Occupation']; ?>">
            </div>

            <div class="form">
                    <p>Partner</p>
                    <input type="text" class="form-item" name="relationship" value="<?php 
										
					$userRelation = $users->GetUserByID($userInfo['Relationship']);
					
					echo $userRelation['Email']; 
					
					?>">
            </div>

            <div class="form">
                    <p>Birthday</p>
                    <input type="date" class="form-item" name="bday" value="<?php echo $userInfo['Birthday']; ?>">
            </div>
            
            <div class="form spacing">
    	            <input type="reset" class="form-button" value="Reset Values">
            </div>
        </div>
        
        
        
        
    </form>
    
    <form method="post" class="settings-form-field borderTop" action="settings?id=<?php echo $userID; ?>&form=pass" accept-charset="utf-8">
        <div class="settings-form-subsection noFloat">
        <div class="form">
                <p>Old Password</p>
                <input type="password" class="form-item" name="OldPassword">
        </div>
        
        <div class="form">
                <p>New Password</p>
                <input type="password" class="form-item" name="Password">
        </div>
        
        <div class="form">
                <p>New Password Again</p>
                <input type="password" class="form-item" name="PasswordAgain">
        </div>
        
        <div class="form">
    	                <input type="submit" class="form-button" value="Change Password">
    	        </div>
            </div>
        
    </form>
                                                                
    <form method="post" class="settings-form-field borderTop" accept-charset="utf-8">
        <div class="settings-form-subsection noFloat">
            <div class="form">
                    <p>Password</p>
                    <input type="password" class="form-item" name="DeactivatePass">
            </div>

            <div class="form">
                    <p>Password Again</p>
                    <input type="password" class="form-item" name="DeactivatePassAgain">
            </div>

            <div class="form">
                            <input type="submit" class="form-button" value="Deactivate Account">
            </div>
        </div>
        
    </form>
    
</div>

<?php

	MakeConversationPane();
}