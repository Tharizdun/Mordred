<?php

require_once "Conversations.php";

session_start();

function MakeHeader($title, $bodyClass)
{
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html> 
    <html lang="cs">
    <head>
	  		<meta http-equiv="content-type" content="text/html; charset=utf-8">
			<meta charset="utf-8">
			
            <title>MyFIT - <?php echo $title;?></title>
			
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
			
            <link rel="stylesheet" href="styl.css" type="text/css">
    </head>
<body id="<?php echo $bodyClass;?>">
<?php
}

function MakeMenu()
{	
	MakeOnline();
	
	$users = new Users();
	$user = $users->GetUserInfo($_SESSION['email'], "ID, FirstName, LastName");

?>
		<nav class="navbar sticky-top navbar-expand-lg  navbar-horizontal">
  		<a class="navbar-brand logo" href="homepage">MyFIT</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="homepage">Home <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="profile">
					<?php 
						
						echo $user['FirstName'] . " " .  $user['LastName'];
						
						?> 
						<span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="signout">Sign out<span class="sr-only">(current)</span></a>
      			</li>
    		</ul>
    		<form class="form-inline my-2 my-lg-0"  method="post" action="search" accept-charset="UTF-8">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
      			<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    		</form>
  		</div>
	</nav>
	
	<div class="mainContentArea">
  			<div class="sidebar borderRight">
    			<ul class="nav flex-column menu">
  					<li class="nav-item">
    					<span class="header">Explore</span>
  					</li>
  					<li class="nav-item">
	    				<a class="nav-link active" href="profile">
						<?php 
						
						echo $user['FirstName'] . " " .  $user['LastName'];
						
						?>						
						</a>
  					</li>
  					<li class="nav-item">
	    				<a class="nav-link active" href="homepage">News feed</a>
  					</li>
  					<li class="nav-item">
	    				<a class="nav-link" href="events">Events</a>
  					</li>
  					<li class="nav-item">
	    				<a class="nav-link" href="settings">Settings</a>
  					</li>
				</ul>
				<ul class="nav flex-column menu">
	  				<li class="nav-item">
    					<span class="header">Online friends</span>
	  				</li>
					
					<?php 
						
						$allFriends = $users->GetOnlineFriends($user['ID']);
				
						if ($allFriends != NULL)
						{
							foreach($allFriends as $friend)
							{
								$friendInfo = $users->GetUserByID($friend);
								$friendName = $friendInfo['FirstName'] . " " .  $friendInfo['LastName'];
														
								echo "<li class=\"nav-item\">";
    							echo "<a class=\"nav-link active\" href=\"messages?id=" . $friend . "\">" . $friendName . "</a>";
  								echo "</li>";
								
							}
						}
						
					?>
				</ul>
				<ul class="nav flex-column menu">
	  				<li class="nav-item">
    					<span class="header">Offline friends</span>
	  				</li>
					
					<?php 
						
						$allFriends = $users->GetOnlineFriends($user['ID'], False);
				
						if ($allFriends != NULL)
						{
							foreach($allFriends as $friend)
							{
								$friendInfo = $users->GetUserByID($friend);
								$friendName = $friendInfo['FirstName'] . " " .  $friendInfo['LastName'];
														
								echo "<li class=\"nav-item\">";
    							echo "<a class=\"nav-link active\" href=\"messages?id=" . $friend . "\">" . $friendName . "</a>";
  								echo "</li>";
								
							}
						}
						
					?>
				</ul>
			</div>
<?php
}

function MakeConversationPane()
{
	$users = new Users();
	$convs = new Conversations();
	$user = $users->GetUserInfo($_SESSION['email'], "ID, FirstName, LastName");
	
	?>
	
			<div class="sidebar borderLeft">
				<ul class="nav flex-column menu">
	  				<li class="nav-item">
    					<span class="header">Conversations</span>
	  				</li>
					
					<?php 
						
						$allConversations = $convs->GetAllUserConversations($user['ID']);
				
						if ($allConversations != NULL)
						{						
							foreach($allConversations as $conversation)
							{
								$convUsers = $convs->GetUsersForConversations($conversation);
								
								$convTitle = "";
								
								if (sizeof($convUsers) == 1)
									continue;
								
								foreach($convUsers as $userID)
								{
									if ($userID != $user['ID'])
									{
										$friendInfo = $users->GetUserByID($userID);
										$convTitle .= $friendInfo['FirstName'] . " " .  $friendInfo['LastName'] . ", ";
									}
								}
										
								echo "<li class=\"nav-item\">";
    							echo "<a class=\"nav-link active\" href=\"messages?convID=" . $conversation . "\">" . substr($convTitle, 0, strlen($convTitle) - 2) . "</a>";
  								echo "</li>";	
								
							}
						}
						
						echo "<a href=\"createConversation\" type=\"button\" class=\"btn btn-primary manage\">Create conversation</a>";
						
					?>
				</ul>
			</div>
	</div>
	
	<?php
}

function MakeFooter()
{
?>
<footer>&copy; Svobodní ladiči 2018</footer>
</body>
</html>
<?php
}

function MakeOnline()
{
	$users = new Users();
	$user = $users->SwitchStatus($_SESSION['email']);
}

function MakeOffline()
{
	$users = new Users();
	$user = $users->SwitchStatus($_SESSION['email'], False);
}

function redirect($dest)
{
    $script = $_SERVER["PHP_SELF"];
    if (strpos($dest,'/')) {
        $path = $dest;
    } else {
        $path = substr($script, 0, strrpos($script, '/')) . "/$dest";
    }
    $name = $_SERVER["SERVER_NAME"];
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://$name$path");
}

function require_user()
{
    if (!isset($_SESSION['user']))
    {
        echo "<h1>Access forbidden</h1>";
        exit();
    }
}