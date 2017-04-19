<?php

class CFormation{
	
	public $id;
	public $name;
	
	function __construct($id, $name){
		
		$this->id = $id;
		$this->name = $name;
	}
	
	public static function getUnits($formationID){
		
		
		$units = Formation::getUnits($formationID);
		
		echo json_encode($units);
		
	}
	
	public static function getAll(){
		
		$formations = Formation::getAll();
		
		$results = array();
		foreach($formations as $formation){
			$formation = new CFormation($formation->id, $formation->name);
			array_push($results, $formation);
		}
		return $results;
	}
	
	
}


?>