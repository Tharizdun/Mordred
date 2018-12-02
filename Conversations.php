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
}




