<?php

class Result {
	
	public $id;
	public $name;
	public $creationDate;
	public $completionDate;
	public $formationID;
	public $formationName;
	public $actionID;
	public $actionName;
	public $unitID;
	public $unitName;
	
	function __construct($formationID, $formationName, $unitID, $unitName, $actionID, $actionName, $id, $name, $creationDate, $completionDate) {
       $this->formationID = $formationID;
	   $this->formationName = $formationName;
	   $this->unitID = $unitID;
	   $this->unitName = $unitName;
	   $this->actionID = $actionID;
	   $this->actionName = $actionName;
	   $this->id = $id;
	   $this->name = $name;
	   $this->creationDate = $creationDate;
	   $this->completionDate = $completionDate;
   }
   
   public static function getResults($formations, $units, $actions){
	   
	   $results = array();
	   if(count($actions) != 0){
			foreach($actions as $action)
				$results = array_merge($results, Action::getEvents($action));
	   } 
	   if(count($units) != 0){
		   foreach($units as $unit)
				$results = array_merge($results, Unit::getEvents($unit));
	   }
	   if(count($formations) != 0){
		   foreach($formations as $formation)
				$results = array_merge($results, Formation::getEvents($formation));
	   }
	   
	   
	   return $results;
	   
   }
	
	
}


?>