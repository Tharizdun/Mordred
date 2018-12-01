<?php

require_once "Common.php";
require_once "Posts.php";

if (!empty($_POST)) 
{
    $message = $_POST['message'];
    $email = $_SESSION['email'];
	
	$posts = new Posts();
	
	$posts->AddPost($email, $message);
}

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

MakeHeader("Home", "homepage");

?>

	<nav class="navbar sticky-top navbar-expand-lg  navbar-dark bg-dark">
  		<a class="navbar-brand logo" href="#">MyFIT</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="#">My profile <span class="sr-only">(current)</span></a>
      			</li>
      			<li class="nav-item active">
        			<a class="nav-link" href="signout.php">Sign out<span class="sr-only">(current)</span></a>
      			</li>
    		</ul>
    		<form class="form-inline my-2 my-lg-0">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      			<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
    		</form>
  		</div>
	</nav>
	
	<div class="container-fluid">
		<div class="row flex-xl-nowrap">
  			<div class="col-12 col-md-3 col-xl-2 bd-sidebar sidebar">
    			<ul class="nav flex-column">
  					<li class="nav-item">
    					<a class="nav-link active" href="#">News feed</a>
  					</li>
  					<li class="nav-item">
					    <a class="nav-link" href="messages.php">Messages</a>
  					</li>
  					<li class="nav-item">
    					<a class="nav-link" href="settings.php">Settings</a>
  					</li>
				</ul>
			</div>
			
			<div class="col-12 col-md-9 col-xl-10 py-md-3 pl-md-5 bd-content">
				<form class="homepage-post" method="post" action="homepage.php">
					<div class="post-part">
						<textarea type="text" class="post-item" name="message" placeholder="Post message"></textarea>
					</div>
					<div class="post-part">
						<input type="submit" value="Post" class="post-button">
					</div>
				</form>
				
				<hr>
				
				<?php
				
				$posts = new Posts();
				
				$allPosts = $posts->GetPosts($_SESSION["email"])->fetchAll();
				
				if ($allPosts != NULL)
				{						
					$users = new Users();
						
					for ($i = 0; $i < sizeof($allPosts); $i++)
					{
						$post = $allPosts[$i];
						
						$userInfo = $users->GetUserByID($post['IDUser']);
						$userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];
						
						echo "<div class=\"post\">";
						echo "	<p class=\"title\">";
						echo "		<span class=\"author\">" . $userName . "</span>";
						echo "		<span class=\"time\">" . $post['Time'] . "</span>";
						echo "	</p>";
						echo "	<div class=\"message\">";
						echo $post['Message'];
						echo "	</div>";
						echo "</div>";
					}
				}
				
				?>			
				
			</div>
		</div>
	</div>

<?php
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