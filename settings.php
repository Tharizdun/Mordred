<?php

require_once "Common.php";

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

MakeHeader("Home", "homepage");

MakeMenu();

?>



<?php
}