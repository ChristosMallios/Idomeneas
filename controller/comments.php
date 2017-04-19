<?php

class CComment {
	
	public $id;
	public $type;	//description (1), comment (2)
	public $user;
	public $dateTime;
	public $parent;
	public $description;
	public $event;
	
	function __construct($id, $type, $user, $dateTime, $parent, $description, $event) {
		
		$this->id = $id;
		$this->type = $type;
		$this->user = $user;
		$this->dateTime = $dateTime;
		$this->parent = $parent;
		$this->description = $description;
		$this->event = $event;
	}
	
	public static function getComments($eventID){
		
		/*$comments = array();
		$user1 = new CUser(1, 'Petros Megistanos', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ.png');
		$comment = new CComment(1, 1, $user1, '27/3/2016 15:45', null, $eventID.'Περιγραφή!! Κάτι πρέπει να προσθέσω για να φανεί κάτι!!', $eventID);
		array_push($comments, CComment::toArray($comment));
						
		$user2 = new CUser(2, 'Nikos Koronas', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ', 'ΑΝΤΙΣΤΡΑΤΗΓΟΣ.png');
		$comment = new CComment(2, 2, $user2, '27/3/2016 15:53', 1, $eventID.'||Υποσχόλιο για δοκιμή. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ!', $eventID);
		array_push($comments, CComment::toArray($comment));
						
		$comment = new CComment(3, 2, $user1, '28/3/2016 12:30', 1, $eventID.'Υποσχόλιο για δοκιμή 2. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ!', $eventID);
		array_push($comments, CComment::toArray($comment));
						
		$comment = new CComment(4, 1, $user2, '27/3/2016 17:20', null, $eventID.'Προσθήκη νέου σχολίου ρίζα. Κάτι έπρεπε να βάλω για δοκιμή', $eventID);
		array_push($comments, CComment::toArray($comment));
						
		$comment = new CComment(5, 1, $user1, '27/3/2016 17:20', null, $eventID.'ΤΕΛΟΣ!!', $eventID);
		array_push($comments, CComment::toArray($comment));
		*/
		
		
		$results = Comment::getComments($eventID);
		$comments = array();
		foreach($results as $result){
			$user = new CUser($result->user->id, null, null, $result->user->name, $result->user->rank, $result->user->rank.'.png');
			$type = 1;
			if($result->parent != null)
				$type = 2;
			$comment = new CComment($result->id, $type, $user, $result->dateTime, $result->parent, $result->description, $result->event);
			array_push($comments, $comment);
		}
		
		echo json_encode($comments);
	}
	
	public static function updateState($eventID){
		
		Comment::updateState($eventID);
	}
	
	public static function deleteComment($commentID){
		
		Comment::deleteComment($commentID);
	}
	
	public static function updateComment($commentID, $description) {
		Comment::updateComment($commentID, $description);
	}
	
	public static function insertComment($description, $eventID, $userID, $parent){
		Comment::insertComment($description, $eventID, $userID, $parent);
	}
	
	private static function toArray($data)
	{
		$result = array();
		$result[0] = $data->id;
		$result[1] = $data->type;
		$result[2] = array($data->user->id, $data->user->name, $data->user->photo);
		$result[3] = $data->dateTime;
		$result[4] = $data->description;
		$result[5] = $data->parent;
		
	 
		return $result;
	}
	
}

?>