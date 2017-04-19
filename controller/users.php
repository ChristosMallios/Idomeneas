<?php

class CUser {
	
	public $id;
	public $username;
	public $password;
	public $name;
	public $rank;
	public $photo;
	
	function __construct($id, $username, $password, $name, $rank, $photo){
		
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->name = $name;
		$this->rank = $rank;
		$this->photo = $photo;
	}
	
	public static function login($username, $password){
		
		$result = User::login($username, $password);
		
		if($result != null)
			return new CUser($result->id, $result->username, $result->password, $result->name, $result->rank, null);
		else
			return null;
	}
	
}

?>