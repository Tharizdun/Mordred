<?php

require_once "Common.php";
require_once "Users.php";

$id = -1;

if (!empty($_GET))
{
	$id = $_GET['id'];
}

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{
	$users = new Users();
	$userName = "";
	
	$isOwner = $users->GetUserInfo($_SESSION['email'], "Admin");
	$isOwner = $isOwner['Admin'];

	if ($id == -1)
	{
		$userName = $users->GetUserInfo($_SESSION['email'], "FirstName, LastName");
		$isOwner = $isOwner || True;
	}
	else
		$userName = $users->GetUserByID($id);

	MakeHeader($userName['FirstName'] . " " .  $userName['LastName'], "homepage");

	MakeMenu();

?>
			
		<h1 class="user-name"><?php echo $userName['FirstName'] . " " .  $userName['LastName']; ?></h1>
		
		<?php 
		
			if ($isOwner)
			{
				echo "<div class=\"btn-group\" role=\"group\" aria-label=\"Manage user\">";
				echo "	<button type=\"button\" class=\"btn btn-secondary\">Media content</button>";
  				echo "	<button type=\"button\" class=\"btn btn-secondary\">Friends</button>";
  				echo "	<button type=\"button\" class=\"btn btn-secondary\">Settings</button>";
				echo "</div>";
			}
		
		?>

<?php
}