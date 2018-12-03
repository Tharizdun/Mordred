<?php

require_once "Common.php";
require_once "Authorization.php";

$showAlert = false;
$showSignOut = false;
$email = "";

if (!empty($_POST)) 
{
    $email = $_POST['email'];
    $pass = $_POST['password'];
	
	$auth = new Authorization();
	
    if ($auth->AuthorizeUser($email, $pass))
        $_SESSION['email'] = $email;
	else
		$showAlert = true;
}

if (!empty($_GET))
{
	if (isset($_GET['email']))
		$email = $_GET['email'];
		
	if (isset($_GET['signout']))
		$showSignOut = $_GET['signout'];
}

if (isset($_SESSION['email']))
{
	MakeOnline();
    redirect('homepage');
}
else
{

MakeHeader("Login", "login");

if ($showAlert)
{
	echo "<div class=\"alert alert-danger alert-message\" role=\"alert\">";
  	echo "Your email or password was incorrect. If you don't have account, you could <a href=\"register?email=" . $email . "\" class=\"alert-link\">register</a>.";
	echo "</div>";
}

if ($showSignOut)
{
	echo "<div class=\"alert alert-success alert-message\" role=\"alert\">";
  	echo "You have been signed out";
	echo "</div>";
}

?>
	<div id="login-form">
        <form method="post" action="index" id="form" accept-charset="utf-8">
                <div class="form header">
                        <p>MyFIT</p>
                </div>

                <div class="form">
                        <p>Email</p>
                        <input type="email" class="form-item" name="email" value="<?php echo $email;?>">
                </div>

                <div class="form">
                        <p>Password</p>
                        <input type="password" class="form-item" name="password">
                </div>

                <div class="form-button-group">
                        <input type="submit" class="form-button" value="Log in">
                        <div class="form-button-separator"></div>
                        <a class="form-button" href="register">Register</a>
                </div>

                                <div class="form footer">
                                        <p>Svobodní ladiči &copy; 2018</p>
                                </div>
          </form>
      </div>
	
<?php
}
