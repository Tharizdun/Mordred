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
			
				if (strpos(strtolower($post['Message']), $query) == True || $query == $posterName || $query == $posterNameReverse || $query == strtolower($poster['FirstName']) || $query == strtolower($poster['LastName']))
				{
					array_push($searchedPosts, $post);
				}
			}
			
		return $searchedPosts;
	}
}