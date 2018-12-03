<?php

require_once "Posts.php";

class Posts
{
	private $dbc;
	private $users;
	private $convs;

	function __construct()
	{
		$this->dbc = new DBConnect();
		$this->users = new Users();
		$this->convs = new Conversations();
	}

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
	}
}