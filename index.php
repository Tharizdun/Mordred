<?php

require_once "Common.php";
require_once "Authorization.php";

if (!empty($_POST)) 
{
    $email = $_POST['email'];
    $pass = $_POST['password'];
	
	$auth = new Authorization();
	
    if ($auth->AuthorizeUser($email, $pass))
    {
        $_SESSION['email'] = $email;
    }
	else
	{
	}
}

if (isset($_SESSION['email']))
{
	MakeOnline();
    redirect('homepage');
}
else
{

MakeHeader("Login", "login");

?>

	<div id="login-form">
        <form method="post" action="index" id="form" accept-charset="utf-8">
                <div class="form header">
                        <p>MyFIT</p>
                </div>

                <div class="form">
                        <p>Email</p>
                        <input type="email" class="form-item" name="email">
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
