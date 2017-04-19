<?php

class Comment {
	
	public $id;
	public $user;
	public $dateTime;
	public $parent;
	public $description;
	public $event;
	
	function __construct($id, $user, $dateTime, $parent, $description, $event) {
		
		$this->id = $id;
		$this->user = $user;
		$this->dateTime = $dateTime;
		$this->parent = $parent;
		$this->description = $description;
		$this->event = $event;
	}
	
	public static function getComments($eventID){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT `id`, `event`, `user`, `parent`, `description`, `date`, `name`, `rank`, `MaterializedPath` 
					FROM (
					SELECT comments.`id` AS `id`, `event`, `user`, `parent`, `description`, `dateTime` AS `date`, `name`, `rank`,  comments.`id` AS MaterializedPath 
					FROM comments, users 
					WHERE parent IS NULL AND `event`=? AND `user`=users.`id`
					UNION ALL
					SELECT comments.`id` AS `id`, `event`, `user`, `parent`, `description`, `dateTime` AS `date`, `name`, `rank`, `parent` AS MaterializedPath 
					FROM comments, users 
					WHERE parent IS NOT NULL AND `event`=? AND `user`=users.`id`
					ORDER BY `materializedPath` ASC, `parent` ASC, `date` ASC) Results";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('ii', $eventID, $eventID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($id, $event, $userID, $parent, $description, $dateTime, $userName, $rank, $materializedPath))
			throw new Exception('QueryError');
		
		$comments = array();
		while($result->fetch()){
			$user = new User($userID, null,null, $userName, $rank);
			$comment = new Comment($id, $user, $dateTime, $parent, $description, $event);
			array_push($comments, $comment);
		}
		return $comments;
	}
	
	public static function updateState($eventID){
		
		$connection = Database::createNewConnection();
		
		date_default_timezone_set("Europe/Athens");
		$today = date("Y-m-d");
		
		$query = "UPDATE events SET `completed`=1, `end`=? WHERE `id`=?";
				  
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
	
		if(!$result->bind_param('si', $today, $eventID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
	}
	
	public static function insertComment($commentDescr, $eventID, $userID, $parent){
		
		$connection = Database::createNewConnection();
		
		date_default_timezone_set("Europe/Athens");
		$date = date("Y-m-d H:i:s");
		
		$query = "INSERT INTO `comments` (comments.`description`, comments.`event`, comments.`user`, comments.`parent`, comments.`dateTime` ) VALUES (?,?,?,?,?)";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('siiis', $commentDescr, $eventID, $userID, $parent, $date))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
	public static function updateComment($commentID, $description){
		
		$connection = Database::createNewConnection();
		
		
		$query = "UPDATE comments SET 
					comments.`description` = ?
					WHERE comments.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('si', $description, $commentID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	public static function deleteComment($commentID){
		
		$connection = Database::createNewConnection();
		
		$query = "DELETE FROM `comments` WHERE `comments`.id = ?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $commentID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
}

?>