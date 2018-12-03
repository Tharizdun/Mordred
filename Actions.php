<?php

require_once "Posts.php";

class Actions
{
	private $dbc;
	private $users;
	private $convs;
	private $posts;

	function __construct()
	{
		$this->dbc = new DBConnect();
		$this->users = new Users();
		$this->convs = new Conversations();
		$this->posts = new Posts();
	}
	
	function AddEvent($creatorID, $title, $description, $time, $date, $place)
	{
		$query = "INSERT INTO `xzedni12`.`Events` (`ID`, `Title`, `Description`, `Time`, `Date`, `Place`, `Deleted`) VALUES (NULL, '" . $title . "', '" . $description . "', '" . $time . "', '" . $date . "', '" . $place . "', '0');";
		$this->dbc->DoQuery($query);
		
		$eventID = $this->dbc->Select("Events", "ID", NULL, "ORDER BY `ID` DESC")->Fetch();
		
		if ($eventID != NULL)
			$eventID = $eventID[0];
			
		$this->AddEventUser($eventID, $creatorID, "creators");
	}
	
	function GetEvent($eventID)
	{
		return $this->dbc->Select("Events", "*", "ID='" . $eventID . "'");
	}
	
	function GetEvents($userID)
	{
		$events = array();
		$participiant = array();
	
		$allEvents = $this->dbc->Select("Events", "*", "Deleted <> 1")->FetchAll();
		$allAttended = $this->dbc->Select("EventsAttended", "IDEvent", "IDUser='" . $userID . "'")->FetchAll();
		$allCreated = $this->dbc->Select("EventsCreators", "IDEvent", "IDUser='" . $userID . "'")->FetchAll();
		
		foreach($allAttended as $user)
		{
			array_push($participiant, $user[0]);
		}
		
		foreach($allCreated as $user)
		{
			if (!in_array($user[0], $participiant))
				array_push($participiant, $user[0]);
		}
		
		foreach($allEvents as $event)
		{
			if (in_array($event['ID'], $participiant))
				array_push($events, $event);
		}
		
		return $events;
	}
	
	function AddEventUser($eventID, $userID, $type = "attended")
	{
		$table = "";
		
		switch(strtolower($type))
		{
			case "attended":
				$table = "EventsAttended";
				break;
				
			case "creators":
				$table = "EventsCreators";
				break;
				
			default:
				return;
				break;
		}
		
		$query = "INSERT INTO `xzedni12`.`" . $table . "` (`ID`, `IDEvent`, `IDUser`) VALUES (NULL, '" . $eventID . "', '" . $userID . "');";
		$this->dbc->DoQuery($query);
	}
	
	function RemoveEvent($id)
	{
		$this->dbc->Update("Events", "Deleted", "1", "ID = " . $id);
	}
	
	function GetEventPeople($eventID, $type = "attended")
	{
		$table = "";
		
		switch(strtolower($type))
		{
			case "attended":
				$table = "EventsAttended";
				break;
				
			case "creators":
				$table = "EventsCreators";
				break;
				
			default:
				return;
				break;
		}
		
		$usersList = array();
		
		$allUsers = $this->dbc->Select($table, "IDUser", "IDEvent='" . $eventID . "'");
		
		foreach($allUsers as $user)
		{
			array_push($usersList, $user[0]);
		}
		
		return $usersList;
	}	
}