<?php
require_once 'include.php';

class Formation{
	
	public $id;
	public $name;
	function __construct($id, $name){
		
		$this->id = $id;
		$this->name = $name;
	}
	
	public static function getUnits($formationID){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT units.`id` AS `unitID`, units.`name` AS `unitName` FROM formations, units WHERE `formation`=formations.`id` AND formations.`id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $formationID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($unitID, $unitName))
			throw new Exception('QueryError');
		
		$units = array();
		while($result->fetch()){
			
			$unit = new Unit($unitID, $unitName, null);
			array_push($units, $unit);
		}
		return $units;
	}
	
	public static function getAll(){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT `id`, `name` FROM formations ORDER BY `name`";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
		
		if(!$result->bind_result($id, $name))
			throw new Exception('QueryError');
		
		$formations = array();
		while($result->fetch()){
			
			$formation = new Formation($id, $name);
			array_push($formations, $formation);
		}
		return $formations;
	}
	
	public static function getEvents($formation){
		
		$connection = Database::createNewConnection();
		
		$query = "SELECT formations.`id`, formations.`name`, units.`id`, units.`name`, actions.`id`, actions.`name`, `start`, `end`, `completed`, events.`id`, `events`.name 
					FROM actions, units, formations, events
					WHERE `unit`=units.`id` AND `formation`=formations.`id` AND `action`=actions.`id` AND formations.`id`=?
					ORDER BY `formation`, `unit`, actions.`id`";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $formation))
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
	
	public static function insertFormation($formationName){
		
		$connection = Database::createNewConnection();
		
		$query = "INSERT INTO formations (formations.`name`) VALUES (?)";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('s', $formationName))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
	public static function updateFormation($formationID, $formationName){
		
		$connection = Database::createNewConnection();
		
		$query = "UPDATE formations SET formations.`name`=? WHERE `id`=?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('si', $formationName, $formationID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
	}
	
	public static function deleteFormation($formationID){
		
		$connection = Database::createNewConnection();
		
		$query = "DELETE `formations`, `units`, `actions`, `events`, `comments` 
					FROM `formations` LEFT JOIN `units`
					ON `units`.formation = `formations`.id LEFT JOIN `actions`
					ON `actions`.unit = `units`.id LEFT JOIN `events`
					ON `events`.action = `actions`.id LEFT JOIN `comments`
					ON `comments`.event = `events`.id
					WHERE `formations`.id = ?";
		
		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('i', $formationID))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		return 0;
		
	}
	
	
}


?>