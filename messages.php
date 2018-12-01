<?php

require_once "Common.php";

/*if (!empty($_POST)) 
{
    $message = $_POST['message'];
    $email = $_SESSION['email'];
	
	$posts = new Posts();
	
	$posts->AddPost($email, $message);
}*/

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

MakeHeader("Messages", "homepage");

MakeMenu();

?>



<?php

	MakeConversationPane();
}