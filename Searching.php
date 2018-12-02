<?php

require_once "Posts.php";

class Searching
{
	private $users;
	private $posts;

	function __constructor()
	{
		$this->users = new Users();
		$this->posts = new Posts();
	}
	
	function GetUsers($query)
	{
		$searchedUsers = array();
		$query = strtolower($query);
		
		$this->users = new Users();
		
		$allUsers = $this->users->GetAllUsers();
		
		if ($allUsers != NULL)
			foreach($allUsers as $user)
			{
				$userName = strtolower($user['FirstName'] . " " . $user['LastName']);
				$userNameReverse = strtolower($user['LastName'] . " " . $user['FirstName']);
			
				if ($query == $userName || $query == $userNameReverse || $query == strtolower($user['FirstName']) || $query == strtolower($user['LastName']) || $query == strtolower($user['School']) || $query == strtolower($user['Residence']) || $query == strtolower($user['Phone']) || $query == strtolower($user['Email']) || $query == strtolower($user['Occupation']))
				{
					array_push($searchedUsers, $user);
				}
			}
			
		return $searchedUsers;
	}
	
	function GetPosts($query)
	{
		$searchedPosts = array();
		$query = strtolower($query);
		
		$this->posts = new Posts();
		$this->users = new Users();
		
		$allPosts = $this->posts->GetAllPosts();
		
		if ($allPosts != NULL)
			foreach($allPosts as $post)
			{
				$poster = $this->users->GetUserByID($post['IDUser']);
				$posterName = strtolower($poster['FirstName'] . " " . $poster['LastName']);
				$posterNameReverse = strtolower($poster['LastName'] . " " . $poster['FirstName']);
			
				if ((stripos($post['Message'], $query) !== False) || $query == $posterName || $query == $posterNameReverse || $query == strtolower($poster['FirstName']) || $query == strtolower($poster['LastName']))
				{
					array_push($searchedPosts, $post);
				}
			}
			
		return $searchedPosts;
	}
}