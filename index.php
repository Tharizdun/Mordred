<?php
session_start();

if (!empty($_POST)) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email == 'user@domain.com' && $password == 'alenajesamadoma')
    {
        $_SESSION['email'] = $email;
    }
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

if (isset($_SESSION['email']))
{
    redirect('homepage.php');
}
else
{

?>
    <html lang="cs">
    <head>
            <meta charset="utf-8">
            <title>Login</title>
            <link rel="stylesheet" href="styl.css" type="text/css">
    </head>
    <body>


    <div id="login">
    <form method="post" action="index.php" id="form">
            <div class="form">
                    <p>E-mail</p>
                    <input type="email" class="form-item" name="email">
            </div>

            <div class="form">
                    <p>Password</p>
                    <input type="password" class="form-item" name="password">
            </div>

            <div class="form-button">
                    <input type="submit" class="form-item" value="Log-in">
            </div>
    </form>
    </div>


    </body>
    </html>
<?php
}
