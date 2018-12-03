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
	
		$allEvents = $this->dbc->Select("Events")->FetchAll();
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
	
	//-----------
	
	
	
	
	/*
	function AddPost($email, $message)
	{
		$userID = $this->users->GetUserInfo($email, "ID");
		
		$taggedUsers = $this->convs->GetTag($message, False);
		
		if ($userID == NULL)
			return false;
		else 
		{
			$query = "INSERT INTO `xzedni12`.`Posts` (`ID`, `IDUser`, `Message`, `Time`, `Shared`, `Deleted`) VALUES (NULL, '" . $userID['ID'] . "', '" . $message . "', CURRENT_TIMESTAMP, '1', '0');";
			
			$this->dbc->DoQuery($query);
			
			$lastPostID = $this->GetLatestPostId();
			
			foreach($taggedUsers as $taggedUserID)
			{
				if ($taggedUserID == $userID['ID'])
					continue;
					
				$this->AddPostTag($lastPostID, $taggedUserID);
			}
		}
	}
	
	function GetPosts($email, $includeFriends = true)
	{
		$userID = $this->users->GetUserInfo($email, "ID");		
		$tagPosts = $this->GetTagPosts($userID);		
		$friendPosts = "";
		$posts = array();
		$validUsers = array();
		array_push($validUsers, $userID['ID']);
		
		if ($includeFriends)
		{
			$friendList = $this->users->GetFriends($userID['ID']);
			
			foreach ($friendList as $friend)
			{
				//$friendPosts .= "OR IDUser = '" . $friend . "'";
				array_push($validUsers, $friend);
			}
		}
		
		$allPosts = $this->GetAllPosts();
		
		foreach($allPosts as $post)
		{
			if (in_array($post['IDUser'], $validUsers) || in_array($post['ID'], $tagPosts))
				array_push($posts, $post);
		}
		
		//return $this->dbc->Select("Posts", "*", "Deleted <> 1 AND (IDUser = '" . $userID['ID'] . "'" . $friendPosts . ")")->FetchAll();
		return $posts;
	}
	
	function GetAllPosts()
	{		
		return $this->dbc->Select("Posts", "*", "Deleted <> 1")->FetchAll();
	}
	
	function DeletePost($id)
	{
		$this->dbc->Update("Posts", "Deleted", "1", "ID = " . $id);
	}
	
	function AddPostTag($postID, $userID)
	{
		$query = "INSERT INTO `xzedni12`.`PostsTag` (`ID`, `IDUser`, `IDTag`) VALUES (NULL, '" . $userID . "', '" . $postID . "');";
			
		$this->dbc->DoQuery($query);
	}
	
	function GetLatestPostID()
	{
		$lastPostID = $this->dbc->Select("Posts", "ID", NULL, "ORDER BY `ID` DESC")->Fetch();
		
		if ($lastPostID != NULL)
			$lastPostID = $lastPostID[0];
		
		return $lastPostID;
	}
	
	function GetTagPosts($userID)
	{
		$tagPosts = array();
	
		$tagList = $this->dbc->Select("PostsTag", "IDTag", "IDUser='" . $userID . "'")->FetchAll();
		
		foreach($tagList as $tagPost)
		{
			array_push($tagPosts, $tagPost[0]);
		}
		
		return $tagPosts;
	}*/
	
}