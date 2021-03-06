<?php

require_once "Common.php";
require_once "Posts.php";
require_once "Conversations.php";

if (!empty($_POST)) 
{
    $message = $_POST['message'];
    $email = $_SESSION['email'];
	
	$posts = new Posts();
	
	$posts->AddPost($email, $message);
}

if (!empty($_GET))
{
	$id = $_GET['id'];
	$action = $_GET['action'];
	
	switch($action)
	{
		case 'delete':
			$posts = new Posts();
			
			$posts->DeletePost($id);
			break;
	}
}

$page = "homepage";
$sec = "30";
header("Refresh: $sec; url=$page");

if (!isset($_SESSION['email']))
{
    redirect('index');
}
else
{

MakeHeader("Home", "homepage");

MakeMenu();

?>
			
			<div class="messages">
                            <h1 class="separator2">What are you doing today?</h1>
                                <div class="chatArea2">
                                    <form class="messages-post" method="post" action="homepage" accept-charset="UTF-8">
                                            <textarea type="text" class="input-area" name="message" placeholder="Post message"></textarea>
                                            <input type="submit" value="Post" class="post-button">
                                    </form>
                                </div>
				
				<div class="separator">
                                    <hr>
                                </div>
             
				<div class="messageWindow">
				<?php
				
				$posts = new Posts();
                                $convs = new Conversations();
				
				$allPosts = $posts->GetPosts($_SESSION["email"]);
				
				if ($allPosts != NULL)
				{						
					$users = new Users();
					
					$allPosts = array_reverse($allPosts);
					
					$isUserAdmin = $users->GetUserInfo($_SESSION['email'], "Admin");
					$isUserAdmin = $isUserAdmin['Admin'];
						
					foreach($allPosts as $post)
					{
						$userInfo = $users->GetUserByID($post['IDUser']);
						$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
						
						$owner = $userInfo['Email'] == $_SESSION['email'];
						
						echo "<div class=\"post\">";
						echo "	<p class=\"title\">";
						echo "		<span class=\"author\"><a href=\"profile?id=" . $post['IDUser'] . "\">" . $userName . "</a></span>";
						echo "		<span class=\"time\">" . $post['Time'] . "</span>";
						echo "	</p>";
						echo "	<div class=\"message\">";
						echo $convs->GetTag($post['Message']);
						echo "	</div>";
						
						if ($owner || $isUserAdmin)
							echo "<a href=\"homepage?action=delete&id=" . $post['ID'] . "\" type=\"button\" class=\"btn btn-primary manage\">Delete post</a>";
						
						echo "</div>";
					}
				}
				
				?>
				</div>
			</div>

<?php

	MakeConversationPane();
}


/*
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<a class="navbar-brand" href="#">MyFIT</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link" href="#">Link</a>
      			</li>
      			<li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          				Dropdown
        			</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          				<a class="dropdown-item" href="#">Action</a>
          				<a class="dropdown-item" href="#">Another action</a>
          				<div class="dropdown-divider"></div>
          				<a class="dropdown-item" href="#">Something else here</a>
        			</div>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link disabled" href="#">Disabled</a>
      			</li>
    		</ul>
    		<form class="form-inline my-2 my-lg-0">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    		</form>
  		</div>
	</nav> */