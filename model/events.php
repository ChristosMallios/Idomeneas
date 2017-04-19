<?php
require_once 'include.php';

class Event{
	
	public $id;
	public $name;
	public $action;
	public $completed;
	public $startDate;
	public $endDate;
	
	function __construct($id, $name, $action, $completed, $start, $end){
		
		$this->id = $id;
		$this->name = $name;
		$this->action = $action;
		$this->completed = $completed;
		$this->startDate = $start;
		$this->endDate = $end;
	}
	
	public static function getAllEvents(){
		
		$connection = Database::createNewConnection();
		
		$query = 	"SELECT events.`id` AS `id`, events.`name` AS `name`, `completed`, `start`, `end`, `action`, 
						actions.`name` AS `actionName`, `unit`, units.`name` AS `unitName`, `formation`, formations.`name` AS `name`
					FROM events, actions, units, formations
					WHERE actions.`id`=`action` AND units.`id`=`unit` AND formations.`id`=`formation`
					ORDER BY formations.`id`, units.`id`, actions.`id`";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($id, $name, $completed, $start, $end, $actionID, $actionName, $unitID, $unitName, $formationID, $formationName))
			throw new Exception('QueryError');
		
		$events = array();
		
		while($result->fetch()){
			
			$formation = new Formation($formationID, $formationName);
			$unit = new Unit($unitID, $unitName, $formation);
			$action = new Action($actionID, $actionName, $unit);
			$event = new Event($id, $name, $action, $completed, $start, $end); 
			array_push($events, $event);
		}
		
		return $events;
		
	}
	
	public static function insertEvent($eventName, $actionID, $user, $commentDescr){
		
		$connection = Database::createNewConnection();
		
		date_default_timezone_set("Europe/Athens");
		$date = date("Y-m-d H:i:s");
		
		if(!$connection->autocommit(false)){
			throw new QueryError();
		}
		
		$query = "INSERT INTO `events` (events.`name`, events.`action`, events.`completed`, events.`start`, events.`user` ) VALUES (?,?,0,?,?)";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('sisi', $eventName, $actionID, $date, $user))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		$query = "SELECT `id` FROM events WHERE `name`=?";	

		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('s', $eventName))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
	
		$count = $result->num_rows;
		
		if(!$result->bind_result($eventID)){
			throw new Exception('QueryError');
		}
		
		$result->fetch();
		
		Comment::insertComment($commentDescr, $eventID, $user, null);
		
		if (!$connection->commit()){
			$connection->autocommit(true);
			throw new QueryError();
		}
		$connection->autocommit(true);
		
		
		return 0;
		
	}
	
	public static function updateEventStatus($eventID, $status){
		
		$connection = Database::createNewConnection();
		
		$query = "UPDATE events SET events.`completed`=? WHERE events.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('ii', $status, $eventID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	
	public static function updateEvent($eventID, $eventName, $actionID, $completed, $start, $end, $user){
		
		$connection = Database::createNewConnection();
		
		$query = "UPDATE events SET 
					events.`name`=?,
					events.`action`=?,
					events.`completed`=?,
					events.`start`=?,
					events.`end`=?,
					events.`user`=?
					WHERE events.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('siissii', $eventName, $actionID, $completed, $start, $end, $user, $eventID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	public static function deleteEvent($eventID){
		
		$connection = Database::createNewConnection();
		
		$query = "DELETE `events`, `comments` 
					FROM `events` LEFT JOIN `comments`
					ON `comments`.event = `events`.id
					WHERE `events`.id = ?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $eventID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
}


?>