<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="view/css/header.css">
<link rel="stylesheet" type="text/css" href="view/css/home.css">
<link rel="stylesheet" type="text/css" href="view/css/jquery-ui.css">
<script type="text/javascript" src="view/js/results.js"></script>
 
<script src="view/js/jquery-1.12.4.js"></script>
<script src="view/js/ui.js"></script> 


<?php
	include_once("controller/formations.php");
?>

<script>
  $(function() {
	$("#formations").selectable({
		filter: "li.ui-widget-content",
		selecting: function(event, ui){
			if( $("#formations .ui-selected, #formations .ui-selecting").length > 1){
				$(ui.selecting).removeClass("ui-selecting");
            }
		}
	});
  });
</script>

<script>
  $(function() {
	$("#units").selectable({
		filter: "li.ui-widget-content",
		selecting: function(event, ui){
			if( $("#units .ui-selected, #units .ui-selecting").length > 1){
				$(ui.selecting).removeClass("ui-selecting");
            }
		}
	});
  });
</script>

<script>
  
$(function() {
    $("#actions").bind("mousedown", function(e) {
		e.metaKey = true;
	}).selectable();
	
	$("#actions").selectable({
		selected: function(event, ui) {
			if (!$(ui.selected).hasClass('selected-flag')) {
				$(ui.selected).addClass('selected-flag');
			} else {
				$(ui.selected).removeClass("ui-selected selected-flag");
			}
		}
	});
});
</script>

<script>
function check(){

	alert($("#actions .ui-selected, #formations .ui-selecting").length );
	var actions = $("#actions").children(".ui-selected").map(function () {
				return $(this).text();
			}).get().join('; ').split(";");
			
	for(var i=0; i<actions.length; ++i){
		alert(actions[i]);
	}
}
</script>
  
<script>
  $( function() {
	 $("#formations").on('selectableselected',function(event, ui) {
		
		var formation = $("#formations").children(".ui-selected").map(function () {
				return $(this).attr('id');
			}).get().join('; ');
		
		$.ajax({
        url: 'index.php?class=formations&action=getUnits',
        type: 'GET',
        cache: false,
        data: {"formation" : formation},
		contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(units) {
			
			var list = document.getElementById("units");
			list.innerHTML = "";
			
			var i, element;
			element = document.createElement("li");
			element.setAttribute("class", "custType");
			element.appendChild(document.createTextNode("Μονάδες"));
			list.appendChild(element);

			for(i=0; i<units.length; ++i){
				element = document.createElement("li");
				element.setAttribute("class", "ui-widget-content");
				element.setAttribute("id", units[i].id);
				element.appendChild(document.createTextNode(units[i].name));
				list.appendChild(element);
			}
			list = document.getElementById("actions");
			list.innerHTML = "";
		}
				
		});
	});
 } );
</script>

<script>
  $( function() {
	 $("#units").on('selectableselected',function(event, ui) {
			
		var unit = $("#units").children(".ui-selected").map(function () {
				return $(this).attr('id');
			}).get().join('; ');
			
		
		
		$.ajax({
        url: 'index.php?class=units&action=getActions',
        type: 'GET',
        cache: false,
        data: {"unit" : unit},
		contentType: "application/json; charset=utf-8",
		dataType: "json",
        success: function(actions) {
			
			var list = document.getElementById("actions");
			list.innerHTML = "";
			
			var i, element;
			element = document.createElement("li");
			element.setAttribute("class", "custType");
			element.appendChild(document.createTextNode("Ενέργειες"));
			list.appendChild(element);
		
			for(i=0; i<actions.length; ++i){
				element = document.createElement("li");
				element.setAttribute("class", "ui-widget-content");
				element.setAttribute("id", actions[i].id);
				element.appendChild(document.createTextNode(actions[i].name));
				list.appendChild(element);
			}
		}
				
		});
		
		
	});
 } );
</script>

<script>

	$( function() {
		var dialog;
		
		function addEvent(){
			var action = $("#insert-actions option:selected").val();
			var eventName = $("#nameComment input").val();
			var eventComment = $("#nameComment textarea").val();
			
			alert('Kaboom!');
			
		}

		dialog = $( "#dialog-eventForm" ).dialog({
			autoOpen: false,
			height: 500,
			width: 500,
			modal: true,
			buttons: {
				"Εισαγωγή": addEvent,
				"Cancel": function() {
					dialog.dialog( "close" );
				}
			},
			close: function() {
				dialog.dialog( "close" );
			}
		});


		$( "#createEvent" ).button().on( "click", function() {
			$( "#dialog-eventForm" ).dialog( "open" );
		});
	});
	
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
					selectList.id = "mySelect2";
					myDiv.appendChild(selectList);
					
					var i, element;

					for(i=0; i<actions.length; ++i){
						var option = document.createElement("option");
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
			input.name = "eventName";
			myDiv.appendChild(input);
			
			myDiv.innerHTML = myDiv.innerHTML + '<br\>Σχόλιο ενέργειας: ';
			
			var input = document.createElement("textarea");
			input.name = "eventComment";
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

					for(i=0; i<units.length; ++i){
						var option = document.createElement("option");
						option.value = units[i].id;
						option.text = units[i].name;
						selectList.appendChild(option);
					}
				}
				
			});
		});
	});
	
</script>
  
</head>

<body>

<?php
	include("view/header.php");
?>
<button id="createEvent">Εισαγωγή Παρατήρησης</button>
<div id="information">

<ol id="formations">

<?php
  
	
	echo "<li class='custType'>Σχηματισμοί</li>";
	for($i=0; $i<count($formationsList); ++$i){
		$name = $formationsList[$i]->name;
		$id = $formationsList[$i]->id;
		echo "<li class='ui-widget-content' id='$id'>$name</li>";
	}
?>

</ol>

<ol id="units" style="width: 380px;" >
</ol>
 
<ol id="actions">
</ol>

<form style="display: inline-block;" action="index.php?class=view&action=results" method="post" onSubmit="viewResults();" >
<input type="image" src="view/images/next_button.png" alt="Submit" height="42" width="42" id="next"  >
<input type="hidden" name="formation"id="formation" value="" >
<input type="hidden" name="unit"id="unit" value="" >
<select style="display: none" id="actionData" name="actionData[]" multiple="multiple" ></select>
</form>
 
</div>



</body>
</html>