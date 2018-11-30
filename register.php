<?php

require "Common.php";
require "Authorization.php";

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
    //	redirect('FuckYou.php');
	}
}

if (isset($_SESSION['email']))
{
    redirect('homepage.php');
}
else
{

MakeHeader("Register");

?>

	<div id="login">
	  <div id="login-bg"></div>
      <div id="login-form">
      <form method="post" action="index.php" id="form">
    	        <div class="form header">
    	                <p>MyFIT</p>
    	        </div>
				
    	        <div class="form">
    	                <p>First name</p>
    	                <input type="text" class="form-item" name="firstname">
    	        </div>
				
    	        <div class="form">
    	                <p>Last name</p>
    	                <input type="text" class="form-item" name="lastname">
    	        </div>
				
    	        <div class="form">
    	                <p>Email</p>
    	                <input type="email" class="form-item" name="email">
    	        </div>
				
    	        <div class="form">
    	                <p>Password</p>
    	                <input type="password" class="form-item" name="password">
    	        </div>
				
    	        <div class="form">
    	                <p>Password again</p>
    	                <input type="password" class="form-item" name="password">
    	        </div>
	
    	        <div class="form-button">
    	                <input type="submit" class="form-item" value="Register">
    	        </div>
				
				<div class="form footer">
					<p>Svobodní ladiči &copy; 2018</p>
				</div>
    	</form>
    	</div>
	</div>
	
<?php
}
