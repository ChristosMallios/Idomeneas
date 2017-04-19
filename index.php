<?php

	session_start();

	require_once('config/configs.php');
	require_once('controller/functions.php');
	require_once('controller/include.php');
	require_once('model/include.php');
	
	$appName = "Ιδομενέας";
	
	//checking the session idle time
	if(!checkArr($_SESSION, "keep_login", true)){	
		if(!checkArr($_SESSION, "last_active"))
			$_SESSION['last_active'] = time() + $CONFIG['max_idle_time'];
		else
			if($_SESSION['last_active'] < time()){
				session_unset();
				session_destroy();
			}else
				$_SESSION['last_active'] = time() + $CONFIG['max_idle_time'];
	}
	
	//XSS SECURITY
	if(!checkArr($_SESSION, "last_ip"))
		$_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
	if($_CONFIG['CHECK_LAST_IP'] && $_SESSION['last_ip'] !== $_SERVER['REMOTE_ADDR']){
		session_unset();
		session_destroy();
		die("invalid session");
	}
	
	//XSS SECURITY
	if($_CONFIG['FORM_TOKENS']){
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !checkArr($_POST, "token", checkArr($_SESSION, "token"))) {
			session_unset();
			session_destroy();
			die("invalid form");
		}
		//NEW TOKEN
		$_SESSION['token'] = sha1(uniqid(mt_rand() + intval("E-SC-Project") , true));
		
	}
	
	$userID = null;
	if(checkArr($_SESSION, "user")) {
		$User = unserialize($_SESSION['user']);
		$userID = $User->id;
	} else
		$User = null;
	
	//XSS Security, reject html special characters
	array_walk_recursive($_POST, "my_XSS_SECURE");
	array_walk_recursive($_GET, "my_XSS_SECURE");

	
	if(checkArr($_GET, "class")){
		$class = $_GET['class'];
		$action = $_GET['action'];
	} else{
		$class = $_POST['class'];
		$action = $_POST['action'];
	}
	
	if(($class != "user" || $action != "login") && $User == null)
		require_once("view/login.php");
	else {
	
	$formationsList = CFormation::getAll();
	
	if($class == "session") {
		
		switch($action) {
			case "getID":
				return $User->id;
				break;
			default:
				break;
		}
	} else if($class == "user"){
		
		switch($action) {
			
			case "login":
			
				$username = $_POST["username"];
				$password = $_POST["password"];
				
				$user = null;
				try{
					$user = Cuser::login($username, $password);
				} catch(QueryError $ex){
					$failureMsg = "Παρουσιάστηκε πρόβλημα στον Server";
					require_once('view/error.php');	//error
					exit();
				}
				
				if(checkArr($_POST, "keep_login", 1))
					$_SESSION['keep_login'] = true;
				else
					$_SESSION['keep_login'] = false;
				
				if($user != null){
					
					$_SESSION["user"] = serialize($user);
					$formations = CFormation::getAll();

					header("Location: index.php?class=view&action=home"); 
					exit();
				} else {
					header("Location: index.php?class=view&action=login&error=NoMatch"); 
					exit();
				}
				break;
			default:
				break;
		}
	} else if($class == 'comments'){
		
		switch($action){
			
			case 'get':
			
				$eventID = $_GET["eventID"];
				CComment::getComments($eventID);
				break;
			case 'add':
			
				$description = $_POST["description"];
				$eventID = $_POST["eventID"];
				$userID = $_POST["userID"];
				$parent = null;
				if(isset($_POST["parent"]))
					$parent = $_POST["parent"];
			
				CComment::insertComment($description, $eventID, $userID, $parent);
				break;
			case 'delete':
				
				$commentID = $_POST["commentID"];
				CComment::deleteComment($commentID);
				break;
			case 'update':
			
				$description = $_POST["description"];
				$commentID = $_POST["commentID"];
				CComment::updateComment($commentID, $description);
				break;
			case 'updateState':
			
				$eventID = $_GET["eventID"];
				CComment::updateState($eventID);
				break;
			default:
				break;
		}
	} else if($class == "formations") {
		
		switch($action) {
			
			case 'getUnits':
			
				$formationID = $_GET["formation"];
				CFormation::getUnits($formationID);
				break;
			default:
				break;
		}
	
	} else if($class == "units") {
		
		switch($action) {
			
			case 'getActions':
			
				$unitID = $_GET["unit"];
				CUnit::getActions($unitID);
				break;
			default:
				break;
		}
	
	} else if($class == "view"){
		
		switch($action){
			
			case "login":
			
				if($User == null)
					require_once("view/login.php");
				else {
					header("Location: index.php?class=view&action=home"); 
					exit();
				}
				break;
			case "home":
			
				//$formations = CFormation::getAll();

				require_once("view/home.php");
				break;
			case "new_event":
			
				//$formations = CFormation::getAll();

				require_once("view/newEvent.php");
				break;
				break;
			case "admin":
			
				//$formations = CFormation::getAll();

				require_once("view/admin.php");
				break;
			case "results":
				
				$formationFound = false;
				$unitFound = false;
				$actionFound = false;
				
				$formations = array();
				if(checkArr($_POST, "formation")){
				
					unset($_SESSION["formations"]);
					unset($_SESSION["units"]);
					unset($_SESSION["actionData"]);
				
					if(is_array($_POST["formation"])){
						$i = 0;
						foreach($_POST["formation"] as $formation){
							$formations[$i] = $formation;
							$i++;
						}
					} else
						$formations[0] = $_POST["formation"];
					
					$formationFound = true;
					$_SESSION["formations"] = $formations;
				}
				
				$units = array();
				if(checkArr($_POST, "unit")){
				
					unset($_SESSION["units"]);
					unset($_SESSION["actionData"]);
					
					if(is_array($_POST["unit"])){
						$i = 0;
						foreach($_POST["unit"] as $unit){
							$units[$i] = $unit;
							$i++;
						}
					} else
						$units[0] = $_POST["unit"];
					$unitFound = true;
					$formations = null;
					$_SESSION["units"] = $units;
				}
				
				$actions = array();
				if(checkArr($_POST, "actionData")){
					
					unset($_SESSION["actionData"]);
					
					if(is_array($_POST["actionData"])){
						$i = 0;
						foreach($_POST["actionData"] as $action){
							$actions[$i] = $action;
							$i++;
						}
					} else
						$actions[0] = $_POST["actionData"];
					$_SESSION["actionData"] = $actions;
					$actionFound = true;
					$units = null;
					$formations = null;
				}
				
				if(!$formationFound && !$unitFound && !$actionFound){
					
					$noData = true;
					if(isset($_SESSION)){
						if(isset($_SESSION["formations"])){
							$formations = $_SESSION["formations"];
							$noData = false;
						}
						if(isset($_SESSION["units"])){
							$units = $_SESSION["units"];
							$noData = false;
							$formations = null;
						}
						if(isset($_SESSION["actionData"])){
							$actions = $_SESSION["actionData"];
							$noData = false;
							$units = null;
							$formations = null;
						}
					}
					
					if($noData)
						throw new Exception("No data found");
				}
	
				$results = Result::getResults($formations, $units, $actions);

				require_once("view/results.php");
				
				break;
			default:
				break;
				
		}
	} else if($class == "events") {
		
		switch($action) {
			
			case 'add':
				
				$actionID = $_POST["actionID"];
				$name = $_POST["name"];
				$comment = $_POST["comment"];
				
				CEvent::insertEvent($name, $actionID, $User->id, $comment);
				
				echo 0;
				
				break;
			default:
				break;
		}
	
	} else if($class == "debug"){
		
		switch ($action){
			
			case "getAllEvents":
				$events = Event::getAllEvents();
				for($i=0; $i<count($events); ++$i){
					$event = $events[$i];
					//$action = $observation->action;
					echo $event->name.' '.$event->id.' || '.$event->completed.' || '.$event->start.' || '.$event->end.' || '.$event->action->id.' || '.
						$event->action->name.' || '.$event->action->unit->id.' || '.$event->action->unit->name.' || '.$event->action->unit->formation->id.' || '.$event->action->unit->formation->name;
					echo "<br/>";
				}
				break;
			default:
				break;
		}
		
	}
	}


?>