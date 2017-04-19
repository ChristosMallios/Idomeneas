<?php
require_once 'include.php';

class Unit{
	
	public $id;
	public $name;
	public $formation;
	
	function __construct($id, $name, $formation){
		
		$this->id = $id;
		$this->name = $name;
		$this->formation = $formation;
	}
	
	public static function getActions($actionID){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT `id`, `name` FROM actions WHERE `unit`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $actionID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($actionID, $actionName))
			throw new Exception('QueryError');
		
		$actions = array();
		while($result->fetch()){
			
			$action = new Action($actionID, $actionName, null);
			array_push($actions, $action);
		}
		return $actions;
	}
	
	public static function getEvents($unit){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT formations.`id`, formations.`name`, units.`id`, units.`name`, actions.`id`, actions.`name`, `start`, `end`, `completed`, events.`id`, `events`.name 
					FROM actions, units, formations, events
					WHERE `unit`=units.`id` AND `formation`=formations.`id` AND `action`=actions.`id` AND units.`id`=?
					ORDER BY `formation`, `unit`, actions.`id`";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $unit))
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
	
	public static function insertUnit($unitName, $formationID){
		
		$connection = Database::createNewConnection();
		
		$query = "INSERT INTO `units` (units.`name`, units.`formation`) VALUES (?,?)";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('si', $unitName, $formationID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
	public static function updateUnit($unitID, $formationID, $unitName){
		
		$connection = Database::createNewConnection();
		
		$query = "UPDATE units SET units.`name`=?, units.formation=? WHERE units.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('sii', $unitName, $formationID, $unitID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	public static function deleteUnit($unitID){
		
		$connection = Database::createNewConnection();
		
		$query = "DELETE `units`, `actions`, `events`, `comments` 
					FROM `units` LEFT JOIN `actions`
					ON `actions`.unit = `units`.id LEFT JOIN `events`
					ON `events`.action = `actions`.id LEFT JOIN `comments`
					ON `comments`.event = `events`.id
					WHERE `units`.id = ?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $unitID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
}


?>