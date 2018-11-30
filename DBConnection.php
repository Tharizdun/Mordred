<?php

class DBConnect
{
	
	private $pdo;
	
	function __construct()
	{
		$this->pdo = $this->ConnectDB();
	}
	
	function ConnectDB()
	{
		$dsn = 'mysql:host=localhost;dbname=xzedni12';
		$user = 'xzedni12';
		$pass = '6ufisapu';
		
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
	    $pdo = new PDO($dsn, $user, $pass, $options);
	    return $pdo;
	}
	
	function GetUser($email)
	{
	echo "<script>console.log( 'Debug Objects: DBConnect.php: " . ($this->pdo == NULL ). "' );</script>";
		$user = $this->pdo->query('SELECT Password FROM Users WHERE Email=\'' + $email + '\'');
		return $user;
	}
}

?>