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
		    $pdo = new PDO("mysql:host=localhost;dbname=xzedni12;port=/var/run/mysql/mysql.sock", 'xzedni12', '6ufisapu');
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
			$result = $this->pdo->query($query);
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function Select($table, $columns = "*", $condition = NULL)
	{
		try
		{
			if ($condition != NULL)
				$wherePart = " WHERE " . $condition;
			else
				$wherePart = "";
				
			$result = $this->pdo->query("SELECT " . $columns . " FROM " . $table . $wherePart . " LIMIT 100");
			
			return $result;
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
	
	function Update($table, $column, $value, $condition)
	{
		try
		{
			$result = $this->pdo->query("UPDATE  " . $table . " SET " . $column . " = " . $value . " WHERE " . $condition);
			
			return $result;
		}
		catch (PDOException $e)
		{
			echo "<script>console.log( 'Debug Objects: DBConnect.php: " . $e . " );</script>";
		}
	}
}

?>