<?php

require "Common.php";

if (!empty($_POST)) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email == 'user@domain.com' && $password == 'alenajesamadoma')
    {
        $_SESSION['email'] = $email;
    }
}

if (isset($_SESSION['email']))
{
    redirect('homepage.php');
}
else
{

MakeHeader("Login");

?>

	<div id="login">
	  <div id="login-bg"></div>
      <div id="login-form">
      <form method="post" action="index.php" id="form">
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
	
    	        <div class="form-button">
    	                <input type="submit" class="form-item" value="Log in">
    	        </div>
				
				<div class="form footer">
					<p>Svobodní ladiči &copy; 2018</p>
				</div>
    	</form>
    	</div>
	</div>
	
<?php
}
