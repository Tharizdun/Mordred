<?php

require_once "DBConnection.php";
require_once "Users.php";

class Conversations
{

	private $dbc;
	private $users;
	
	function __construct()
	{
			$this->dbc = new DBConnect();
			$this->users = new Users();
	}
	
	function GetConversationForUser($id, $currentUserID)
	{
		$conversations = array();
	
		$result = $this->dbc->Select("ConversationsUsers", "IDConversation", "IDUser = '" . $currentUserID . "'")->FetchAll();
		
		foreach($result as $conv)
		{
			$conversation = $this->GetUsersForConversations($conv[0]);
			
			if (sizeof($conversation) == 2 && in_array($id, $conversation))
			{
				return $conv[0];
			}
		}
		
		return -1;
	}
	
	function GetConversationForUsers($ids, $currentUserID)
	{
		$conversations = array();
	
		$result = $this->dbc->Select("ConversationsUsers", "IDConversation", "IDUser = '" . $currentUserID . "'")->FetchAll();
		
		foreach($result as $conv)
		{
			$conversation = $this->GetUsersForConversations($conv[0]);
			
			$conversationExist = true;
			
			if (sizeof($conversation) == sizeof($ids) + 1)
			{
				foreach($ids as $user)
				{
					if (!in_array($user, $conversation))
						$conversationExist = false;
				}
				
				if ($conversationExist)
					return $conv[0];
			}
		}
		
		return -1;
	}
	
	function GetUsersForConversations($convID)
	{
		$convUsers = array();
	
		$result = $this->dbc->Select("ConversationsUsers", "IDUser", "IDConversation = '" . $convID . "'")->FetchAll();
		
		foreach($result as $user)
		{
			array_push($convUsers, $user[0]);
		}
		
		return $convUsers;
	}
	
	function GetAllUserConversations($id)
	{
		$conversations = array();
	
		$result = $this->dbc->Select("ConversationsUsers", "IDConversation", "IDUser = '" . $id . "'")->FetchAll();
		
		foreach($result as $conv)
		{
			array_push($conversations, $conv[0]);
		}
		
		return $conversations;
	}
	
	function GetCountOfUsers($convID)
	{		
		return sizeof(GetUsersForConversations($convID));
	}
	
	function GetMessages($convID)
	{		
		$messages = array();
	
		$result = $this->dbc->Select("Messages", "*", "IDConversation = '" . $convID . "'")->FetchAll();
		
		foreach($result as $message)
		{
			array_push($messages, $message);
		}
		
		return $messages;
	}
	
	function CreateConversation($id)
	{
		$query = "INSERT INTO `xzedni12`.`Conversations` (`ID`, `Topic`) VALUES (NULL, '');";
		$this->dbc->DoQuery($query);
		
		$convID = $this->dbc->Select("Conversations", "ID", NULL, "ORDER BY `ID` DESC")->Fetch();
		
		if ($convID != NULL)
			$convID = $convID[0];
			
		$this->AddConvUser($id, $convID);
		
		return $convID;
	}
	
	function AddConvUser($id, $convID)
	{
		$userInConvExist = $this->dbc->Select("ConversationsUsers", "ID", "IDUser = '" . $id . "' AND IDConversation='" . $convID . "'")->FetchAll();
		
		if (sizeof($userInConvExist) == 0)
		{
			$query = "INSERT INTO `xzedni12`.`ConversationsUsers` (`ID`, `IDUser`, `IDConversation`) VALUES (NULL, '" . $id ."', '" . $convID ."');";
			$this->dbc->DoQuery($query);			
		}
	}
	
	function AddMessage($convID, $id, $message)
	{		
		$query = "INSERT INTO `xzedni12`.`Messages` (`ID`, `IDSender`, `IDConversation`, `Time`, `Message`) VALUES (NULL, '" . $id . "', '" . $convID . "', CURRENT_TIMESTAMP, '" . $message . "');";
		$this->dbc->DoQuery($query);
	}
<<<<<<< HEAD
=======
	
	function GetTag($message)
	{
		$tagMessage = $message;
		$restMessage = $message;
		
		while(strpos($restMessage, "~") !== False)
		{
			$sub = substr($restMessage, strpos($restMessage, "~"), strlen($restMessage) - strpos($restMessage, "~") + 1);
			
			if (strpos($sub, " ") !== False)
				$sub = substr($sub, 0, strpos($sub, " "));
			else 
			{
				$reverseSub = strrev($sub);
				
				if (strpos($reverseSub, "~") !== False)
				{
					$endPosition = strpos($reverseSub, "~");
				
					while ($endPosition != strlen($sub) -1)
					{
						if (strpos($reverseSub, "~") == strpos($sub, "~"))
							$sub = substr($sub, 0, strlen($sub) - 1);
						else
							$sub = substr($sub, 0, strlen($sub) - strpos($reverseSub, "~") - 1);
						
						
						$reverseSub = strrev($sub);
						$endPosition = strpos($reverseSub, "~");
					}
				}
			}
			
			$user = $this->users->GetUserInfo(substr($sub, 1, strlen($sub) - 1));
			
			if ($user == NULL)
			{
				$restMessage = substr($restMessage, 1, strlen($restMessage) - 1);
				continue;
			}
			
			$tag = "<a href=\"profile?id=" . $user['ID'] . "\">" . $user['FirstName'] . " " . $user['LastName'] . "</a>";
			
			$tagMessage = str_replace($sub, $tag, $tagMessage);
			
			$restMessage = substr($restMessage, strpos($restMessage, "~") + 1);
		}
		
		return $tagMessage;
	}
>>>>>>> parent of 0bf2ed9... Profile layout changes
}




