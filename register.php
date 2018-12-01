<?php

require_once "Common.php";
require_once "Authorization.php";

if (!empty($_POST)) 
{
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
	
	$users = new Users();
	
	$users->RegisterUser($firstName, $lastName, $email, $pass);
	
	$_SESSION['email'] = $email;
}

if (isset($_SESSION['email']))
{
    redirect('homepage.php');
}
else
{

MakeHeader("Register", "login");

?>

	<div id="login-form">
      	<form method="post" action="register.php" id="form" accept-charset="utf-8">
    	        <div class="form header">
    	                <p>MyFIT</p>
    	        </div>
				
    	        <div class="form">
    	                <p>First name</p>
    	                <input type="text" class="form-item" name="firstName">
    	        </div>
				
    	        <div class="form">
    	                <p>Last name</p>
    	                <input type="text" class="form-item" name="lastName">
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
    	                <input type="password" class="form-item" name="passwordAgain">
    	        </div>
	
    	        <div class="form">
    	                <input type="submit" class="form-button" value="Register">
    	        </div>
	
    	        <div class="form">
    	                <p>Already have account?</p>
    	                <a class="form-button" href="index.php">Log in</a>
    	        </div>
				
				<div class="form footer">
					<p>Svobodní ladiči &copy; 2018</p>
				</div>
    	</form>
    	</div>
	
<?php
}