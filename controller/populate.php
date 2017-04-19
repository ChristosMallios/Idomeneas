<?php

	require_once("../model/include.php");

	for($i=1; $i<279; ++$i){
		Action::insertAction("Μισθοτροφοδοσία", $i);
		Action::insertAction("Καύσιμα", $i);
	}

?>