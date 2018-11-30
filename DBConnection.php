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
		try
		{
		    $pdo = new PDO("mysql:host=localhost;dbname=xzedni12;port=/var/run/mysql/mysql.sock", 'xzedni12', '6ufisapu');
		    return $pdo;
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function GetUser($email)
	{
		try
		{
			$user = $this->pdo->query("SELECT Password FROM Users WHERE Email='" . $email . "'");
			
			if (sizeof($user) == 1)
			{
				$pass = $user->fetch();
				return $pass['Password'];
			}
			else
				return null;	
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
}

?>