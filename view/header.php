

<div id="header">

<div id="upperLeft">

<?php

	echo '<span id="spanName">'.$appName.'</span>';

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
<img id="profile_pic" src="view/images/profile.png" alt="Profile">
<img id="bell" src="view/images/bell.png" alt="Bell">
<img id="sound" src="view/images/sound.png" alt="Sound">
<img id="help" src="view/images/help.png" alt="Help">
<?php
	echo '<span style="display: none;" id="userID">'.$userID.'</span>';
?>

</div>

<script>
	
	$( function() {
		$("#insert-units").change(function() {

			var unit = $("#insert-units option:selected").val();
			
			$.ajax({
				url: 'index.php?class=units&action=getActions',
				type: 'GET',
				cache: false,
				data: {"unit" : unit},
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(actions) {

					var myDiv = document.getElementById("insert-actions");
					myDiv.innerHTML = "";
					myDiv.innerHTML = myDiv.innerHTML + 'Ενέργειες: ';
					
					var selectList = document.createElement("select");
					selectList.name = "actionID";
					selectList.id = "mySelect2";
					myDiv.appendChild(selectList);
					
					var i, element;

					var option = document.createElement("option");
					option.value = -1;
					option.text = "";
					selectList.appendChild(option);
					for(i=0; i<actions.length; ++i){
						option = document.createElement("option");
						option.value = actions[i].id;
						option.text = actions[i].name;
						selectList.appendChild(option);
					}
				}
				
			});
			
			var myDiv = document.getElementById("nameComment");
			myDiv.innerHTML = "";
			myDiv.innerHTML = myDiv.innerHTML + '<br\>Όνομα ενέργειας: ';
			
			var input = document.createElement("input");
			input.type = "text";
			input.name = "name";
			input.id = "eventName";
			input.autocomplete = "off";
			myDiv.appendChild(input);
			
			myDiv.innerHTML = myDiv.innerHTML + '<br\>Σχόλιο ενέργειας: ';
			
			var input = document.createElement("textarea");
			input.name = "commentTxt";
			input.id = "commentTxt";
			myDiv.appendChild(input);
		});
	});

	$( function() {
		$("#insert-formations").change(function() {

			var formation = $("#insert-formations option:selected").val();

			$.ajax({
				url: 'index.php?class=formations&action=getUnits',
				type: 'GET',
				cache: false,
				data: {"formation" : formation},
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success: function(units) {

					var myDiv = document.getElementById("insert-units");
					myDiv.innerHTML = "";
					myDiv.innerHTML = myDiv.innerHTML + 'Μονάδες: ';
					
					var selectList = document.createElement("select");
					selectList.id = "mySelect";
					myDiv.appendChild(selectList);
					
					var i, element;

					var option = document.createElement("option");
					option.value = -1;
					option.text = "";
					selectList.appendChild(option);
					
					for(i=0; i<units.length; ++i){
						option = document.createElement("option");
						option.value = units[i].id;
						option.text = units[i].name;
						selectList.appendChild(option);
					}
				}
				
			});
		});
	});
	$( function() {
		var dialog;
		
		function addEvent(){
			
			var action = $("#mySelect2").val();
			var eventName = $("#eventName").val();
			var eventComment = $("#commentTxt").val();
			
			typeof(variable) != "undefined" && variable !== null
			
			if((typeof(action) == "undefined" || (action == null || action == '')) || 
				(typeof(eventName) == "undefined" || (eventName == null || eventName == '')) || 
				(typeof(eventComment) == "undefined" || (eventComment == null || eventComment == ''))){
				
				alert('Παρακαλώ συμπληρώστε τα απαραίτητα πεδία.');
				
			}else{
				$.ajax({
					url: 'index.php?class=events&action=add',
					type: 'POST',
					cache: false,
					data: {"actionID" : action, "name" : eventName, "comment" : eventComment},
					success: function(statusCode) {

						if(statusCode == 0){
							$('#success').css("display", "block");
							$('#error').css("display", "none");
						} else {
							$('#success').css("display", "none");
							$('#error').css("display", "block");
						}
						
						$("#mySelect2").val("");
						$("#eventName").val("");
						$("#commentTxt").val("");
						$("#insert-formations").val("");
						$("#mySelect").val("");
						
					}
					
				});
			}
			
			
			
			
		}

		dialog = $( "#dialog-eventForm" ).dialog({
			autoOpen: false,
			height: 600,
			width: 600,
			modal: true,
			buttons: {
				"Εισαγωγή": addEvent,
				"Cancel": function() {
					$("#mySelect2").val("");
					$("#eventName").val("");
					$("#commentTxt").val("");
					$("#insert-formations").val("");
					$("#mySelect").val("");
					$('#success').css("display", "none");
					$('#error').css("display", "none");
					dialog.dialog( "close" );
				}
			},
			close: function() {
				$("#mySelect2").val("");
				$("#eventName").val("");
				$("#commentTxt").val("");
				$("#insert-formations").val("");
				$("#mySelect").val("");
				$('#success').css("display", "none");
				$('#error').css("display", "none");
				dialog.dialog( "close" );
			}
		});

		$( "#createEvent" ).button().on( "click", function() {
			$( "#dialog-eventForm" ).dialog( "open" );
		});
		
		$('#createEvent').removeClass("ui-button ui-corner-all ui-widget");
		
		$('#closeSuccess').on("click", function() {
			$('#success').css("display", "none");
		});
		
		$('#closeError').on("click", function() {
			$('#error').css("display", "none");
		});
		
	});
	
</script>

<div id="menu">
	<ul id="menu_list">
		<li class="menu_element"><a class="menu_link_lvl1" href="index.php?class=view&action=home">Αναζήτηση</a></li>
		<li class="menu_element"><a id="createEvent" class="menu_link_lvl1" href="#">Εισαγωγή Νέας Παρατήρησης</a></li>
		<li class="menu_element"><a class="menu_link_lvl1" href="#home">Ειδοποιήσεις</a></li>
		<li class="dropdown" id="menu_element">
			<a class="menu_link_lvl1" href="javascript:void(0)" class="dropbtn">Λειτουργίες Διαχειριστή</a>
			<div class="dropdown-content">
				<a class="menu_link_lvl2" href="#">Διαχείρηση Σχηματισμών</a>
				<a class="menu_link_lvl2" href="#">Διαχείρηση Μονάδων</a>
				<a class="menu_link_lvl2" href="#">Διαχείρηση Ενεργειών</a>
				<a class="menu_link_lvl2" href="#">Διαχείρηση Παρατηρήσεων</a>
				<a class="menu_link_lvl2" href="#">Αναζήτηση Στελέχους</a>
			</div>
		</li>
		<li class="dropdown" id="menu_element">
			<a href="javascript:void(0)" class="dropbtn">Λογαριασμοί</a>
			<div class="dropdown-content">
				<a href="#">Στοιχεία</a>
				<a href="#">Τροποποίηση Στοιχείων Χρήστη</a>
			</div>
		</li>
		<li class="dropdown" id="menu_element">
			<a href="javascript:void(0)" class="dropbtn">Βοήθεια</a>
			<div class="dropdown-content">
				<a href="#">Οδηγίες επίλυσης προβλημάτων</a>
				<a href="#">Εγχειρίδιο χρήσης ΕΦΑΡΜΟΓΗΣ</a>
			</div>
		</li>
	</ul>
</div>

<div id="dialog-eventForm" title="Εισαγωγή νέας Παρατήρησης">

	<span style="display: none;" id="success"><strong>Επιτυχία!</strong> Η εγγραφή πραγματοποιήθηκε. <img style="float: right;" id="closeSuccess" src="view/images/closeIcon.png" width="12" /></span>
	<span style="display: none;" id="error"><strong>Αποτυχία!</strong> Η εγγραφή απέτυχε. Παρακαλώ προσπαθήστε ξανά. <img style="float: right;" id="closeError" src="view/images/closeIcon.png" width="12" /></span>

	<p class="validateTips">Όλα τα πεδία είναι απαραίτητα!</p>
	<form id="addEvent">
		Σχηματισμοί: 
		<select id="insert-formations" >
			<option value='-1'>-</option>
			<?php
				for($i=0; $i<count($formationsList); ++$i){
					$name = $formationsList[$i]->name;
					$id = $formationsList[$i]->id;
					echo "<option value='$id'>$name</option>";
				}
			?>
		</select>
		<div id="insert-units" ></div>
		<div id="insert-actions" ></div>
		<div id="nameComment"></div>
	</form>
</div>



</div>

