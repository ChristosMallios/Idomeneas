<?php

class CUnit{
	
	public $id;
	public $name;
	public $formation;
	
	function __construct($id, $name, $formation){
		
		$this->id = $id;
		$this->name = $name;
		$this->formation = $formation;
	}
	
	public static function getActions($unitID){
		
		
		$actions = Unit::getActions($unitID);
		
		echo json_encode($actions);
		
	}
	
	
}


?>