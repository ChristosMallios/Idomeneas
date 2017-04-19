

<div id="header">

<div id="upperLeft">
<span id="spanName">App Name</span>
<?php
	date_default_timezone_set("Europe/Athens");
	//$currentDate = date("j F Y");
	
	$offset = 3; // +3: Athens
	$months = array( "Ιανουαρίου", "Φεβρουαρίου", "Μαρτίου", "Απριλίου", "Μαΐου", "Ιουνίου", "Ιουλίου", "Αυγούστου", "Σεπτεμβρίου", "Οκτωμβρίου", "Νοεμβρίου", "Δεκεμβρίου" ); 
	$days = array( "Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο" ); 
	$server_now = time(); 
	$local_now = $server_now+($offset*60*60); 
	$day_of_the_week = date("w", $local_now); 
	$day = date("j", $local_now); 
	$month = date("n", $local_now); 
	$year = date("Y", $local_now); 
	$full_greek_date = $days[$day_of_the_week] . ", " . $day . " " . $months[$month - 1] . " " . $year;
	
	echo "<div id='date'>$full_greek_date</div>"
?>
<input id="search" type="text" />
</div>

<div id="upperRight">
<img id="profile_pic" src="images/profile.png" alt="Profile">
<img id="bell" src="images/bell.png" alt="Bell">
<img id="sound" src="images/sound.png" alt="Sound">
<img id="help" src="images/help.png" alt="Help">
</div>

</div>

