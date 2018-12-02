<?php

require_once "Common.php";
require_once "Posts.php";

/*if (!empty($_POST)) 
{
    $message = $_POST['message'];
    $email = $_SESSION['email'];
	
	$posts = new Posts();
	
	$posts->AddPost($email, $message);
}*/

if (!isset($_SESSION['email']))
{
    redirect('index.php');
}
else
{

MakeHeader("Messages", "homepage");

MakeMenu();

?>

<div class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content messages">
    <div class="messageWindow">
        <?php
				
        $posts = new Posts();

        $allPosts = $posts->GetPosts($_SESSION["email"])->fetchAll();

        if ($allPosts != NULL)
        {						
                $users = new Users();

                $allPosts = array_reverse($allPosts);

                $isUserAdmin = $users->GetUserInfo($_SESSION['email'], "Admin");
                $isUserAdmin = $isUserAdmin['Admin'];

                for ($i = 0; $i < sizeof($allPosts); $i++)
                {
                        $post = $allPosts[$i];

                        $userInfo = $users->GetUserByID($post['IDUser']);
                        $userName = $userInfo['FirstName'] . " " .  $userInfo['LastName'];

                        $owner = $userInfo['Email'] == $_SESSION['email'];

                        echo "<div class=\"post\">";
                        echo "	<p class=\"title\">";
                        echo "		<span class=\"author\"><a href=\"profile.php?id=" . $post['IDUser'] . "\">" . $userName . "</a></span>";
                        echo "		<span class=\"time\">" . $post['Time'] . "</span>";
                        echo "	</p>";
                        echo "	<div class=\"message\">";
                        echo $post['Message'];
                        echo "	</div>";

                        if ($owner || $isUserAdmin)
                                echo "<a href=\"homepage.php?action=delete&id=" . $post['ID'] . "\" type=\"button\" class=\"btn btn-primary manage\">Delete post</a>";

                        echo "</div>";
                }
        }

        ?>
    </div>
    
    <div class="chatArea">
        <div class="separator">
            <hr>
        </div>
        <form class="messages-post" method="post" action="homepage.php">
                <textarea type="text" class="input-area" name="message" placeholder="Post message"></textarea>
                <input type="submit" value="Send" class="post-button">
        </form>
    </div>
</div>

<?php

	MakeConversationPane();
}