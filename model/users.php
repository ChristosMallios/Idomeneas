<?php

class User {
	
	public $id;
	public $username;
	public $password;
	public $name;
	public $rank;
	
	function __construct($id, $username, $password, $name, $rank){
		
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->name = $name;
		$this->rank = $rank;
	}
	
	public static function login($username, $password) {
		
		$connection = Database::createNewConnection();
		
		$pass = sha1($password);
		
		$query = "SELECT `id`, `username`, `password`, `name`, `rank` FROM Users WHERE `username`=? AND `password`=?";	

		if(!$result = $connection->prepare($query))
			throw new Exception('QueryError');
		
		if(!$result->bind_param('ss', $username, $pass))
			throw new Exception('QueryError');
		
		if(!$result->execute())
			throw new Exception('QueryError');
		
		if(!$result->store_result())
			throw new Exception('QueryError');
	
		$count = $result->num_rows;
		
		if(!$result->bind_result($id,$username,$password,$name, $rank)){
			throw new Exception('QueryError');
		}
		
		if($count==1){
			$result->fetch();
			$user = new User($id,$username,$password,$name, $rank);
			return $user;
		}
		else {
			return null;
		}
		
	}
	
}

?>