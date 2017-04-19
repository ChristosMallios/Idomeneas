<?php
require_once 'include.php';

class Action{
	
	public $id;
	public $name;
	public $unit;
	
	function __construct($id, $name, $unit){
		
		$this->id = $id;
		$this->name = $name;
		$this->unit = $unit;
	}
	
	public static function getEvents($action){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT formations.`id`, formations.`name`, units.`id`, units.`name`, actions.`id`, actions.`name`, `start`, `end`, `completed`, events.`id`, `events`.name 
					FROM actions, units, formations, events
					WHERE `unit`=units.`id` AND `formation`=formations.`id` AND `action`=actions.`id` AND actions.`id`=?
					ORDER BY `formation`, `unit`, actions.`id`";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $action))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($formationID, $formationName, $unitID, $unitName, $actionID, $actionName, $start, $end, $completed, $eventID, $eventName))
			throw new Exception('QueryError');
		
		$events = array();
		while($result->fetch()){
			
			$unit = new Unit($unitID, $unitName, null);
			$formation = new Formation($formationID, $formationName);
			$unit = new Unit($unitID, $unitName, $formation);
			$action = new Action($actionID, $actionName, $unit);
			$event = new Event($eventID, $eventName, $action, $completed, $start, $end);
			
			array_push($events, $event);
		}
		return $events;
		
	}
	
	public static function insertAction($actionName, $unitID){
		
		$connection = Database::createNewConnection();
		
		$query = "INSERT INTO `actions` (actions.`name`, actions.`unit` ) VALUES (?,?)";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('si', $actionName, $unitID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
	public static function updateAction($actionID, $actionName, $unitID){
		
		$connection = Database::createNewConnection();
		
		$query = "UPDATE actions SET 
					actions.`name`=?,
					actions.`unit`=?
					WHERE actions.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('sii', $actionName, $unitID, $actionID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	public static function deleteAction($actionID){
		
		$connection = Database::createNewConnection();
		
		$query = "DELETE `actions`, `events`, `comments` 
					FROM `actions` LEFT JOIN `events`
					ON `events`.action = `actions`.id LEFT JOIN `comments`
					ON `comments`.event = `events`.id
					WHERE `actions`.id = ?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $actionID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
}


?>