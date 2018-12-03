<?php

require_once "Common.php";

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

MakeHeader("Home", "homepage");

MakeMenu();

?>

<div class="temp-fix">
    
    
    
    
    <form method="post" class="settings-form-field" action="" accept-charset="utf-8">
        <div class="settings-form-subsection">
            <div class="form">
                    <p>First name</p>
                    <input type="text" class="form-item" name="firstName">
            </div>

            <div class="form">
                    <p>Last name</p>
                    <input type="text" class="form-item" name="lastName">
            </div>

            <div class="form">
                    <p>Phone</p>
                    <input type="text" class="form-item" name="phone">
            </div>
            <div class="form">
                <p>Relationship Status</p>
                <select class="form-item">
                    <option name="RelationshipStatus" value="single" checked> single</option>
                    <option name="RelationshipStatus" value="dating"> dating</option>
                    <option name="RelationshipStatus" value="married"> married</option>
                    <option name="RelationshipStatus" value="complicated"> complicated</option>
                    <option name="RelationshipStatus" value="widowed"> widowed</option>
                </select>
            </div>
        </div>
        
        <div class="settings-form-subsection">
            <div class="form">
                    <p>School</p>
                    <input type="text" class="form-item" name="school">
            </div>

            <div class="form">
                    <p>Occupation</p>
                    <input type="text" class="form-item" name="occupation">
            </div>

            <div class="form">
                    <p>Partner</p>
                    <input type="text" class="form-item" name="relationship">
            </div>
            
            <div class="form spacing">
    	            <input type="submit" class="form-button" value="Save Settings">
            </div>
        </div>
        
        
        
        
    </form>
    
    <form method="post" class="settings-form-field borderTop" action="" accept-charset="utf-8">
        <div class="settings-form-subsection noFloat">
        <div class="form">
                <p>Old Password</p>
                <input type="text" class="form-item" name="OldPassword">
        </div>
        
        <div class="form">
                <p>New Password</p>
                <input type="text" class="form-item" name="Password">
        </div>
        
        <div class="form">
                <p>New Password Again</p>
                <input type="text" class="form-item" name="PasswordAgain">
        </div>
        
        <div class="form">
    	                <input type="submit" class="form-button" value="Change Password">
    	        </div>
            </div>
        
    </form>
</div>

<?php

	MakeConversationPane();
}