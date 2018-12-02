<?php

class DBConnect
{
	
	private static $pdo = NULL;
	
	function __construct()
	{
		$this->pdo = $this->ConnectDB();
	}
	
	function ConnectDB()
	{		
		try
		{
		    $pdo = new PDO("mysql:host=localhost;dbname=xzedni12;port=/var/run/mysql/mysql.sock", 'xzedni12', '6ufisapu', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    return $pdo;
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function DoQuery($query)
	{
		try
		{
			return $this->pdo->query($query);
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function Select($table, $columns = "*", $condition = NULL, $addition = "")
	{
		try
		{
			if ($condition != NULL)
				$wherePart = " WHERE " . $condition;
			else
				$wherePart = "";
				
			$result = $this->pdo->query("SELECT " . $columns . " FROM " . $table . $wherePart . " " . $addition);
			
			return $result;
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function Update($table, $column, $value, $condition, $addition = "")
	{
		try
		{
			return $this->pdo->query("UPDATE  " . $table . " SET " . $column . " = " . $value . " WHERE " . $condition . " " . $addition);
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function Delete($table, $condition, $addition = "")
	{
		try
		{
			return $this->pdo->query("DELETE FROM " . $table . " WHERE " . $condition . " " . $addition);
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
}

?>