<?php
require_once 'include.php';

class CEvent{
	
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
	
	public static function insertEvent($eventName, $actionID, $user, $commentDescr){
		
		Event::insertEvent($eventName, $actionID, $user, $commentDescr);
	}
	
}


?>