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
    
    
    
</div>

<?php

	MakeConversationPane();
}